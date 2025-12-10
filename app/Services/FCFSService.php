<?php

namespace App\Services;

use App\Models\Antrean;
use App\Models\Jip;
use App\Models\AlokasiJip;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FCFSService
{
    /**
     * Proses antrean berdasarkan prinsip First Come First Served (FCFS)
     */
    public function prosesAntrean()
    {
        try {
            $counter = 0;
            while ($counter < 10) {
                $now = Carbon::now('Asia/Jakarta');
                $today = $now->toDateString();

                $hour = $now->hour;
                if ($hour >= 4 && $hour < 11) {
                    $sesiAktif = 'Pagi';
                    $rangeJam = ['04:00', '10:59'];
                } elseif ($hour >= 11 && $hour < 14) {
                    $sesiAktif = 'Siang';
                    $rangeJam = ['11:00', '13:59'];
                } elseif ($hour >= 14 && $hour <= 16) {
                    $sesiAktif = 'Sore';
                    $rangeJam = ['14:00', '16:00'];
                } else {
                    $besok = Carbon::tomorrow('Asia/Jakarta')->toDateString();
                    $sesiAktif = 'Pagi';
                    $rangeJam = ['04:00', '10:59'];
                    $today = $besok;
                }

                // Ambil antrean menunggu paling awal untuk hari ini
                $antrean = Antrean::join('pemesanans', 'antreans.pemesanan_id', '=', 'pemesanans.id')
                    ->where('antreans.status', 'menunggu')
                    ->whereDate('pemesanans.tanggal_berangkat', $today)
                    ->where('pemesanans.status', 'disetujui')
                    ->whereBetween('pemesanans.jam_berangkat', $rangeJam)
                    ->orderBy('pemesanans.created_at', 'asc')
                    ->select('antreans.*')
                    ->first();

                if (!$antrean) {
                    break;
                }

                DB::beginTransaction();

                try {
                    // Lock ulang antrean ini untuk memastikan belum diproses
                    $antrean = Antrean::where('id', $antrean->id)
                        ->lockForUpdate()
                        ->first();

                    if (!$antrean || $antrean->status !== 'menunggu') {
                        DB::rollBack();
                        continue;
                    }

                    $pemesanan = $antrean->pemesanan;

                    // Lewati antrean jika pemesanan belum disetujui oleh admin
                    if ($pemesanan->status !== 'disetujui') {
                        Log::info("Antrean #{$antrean->id} dilewati karena pemesanan belum disetujui.");
                        DB::rollBack();
                        continue;
                    }

                    $jumlahDibutuhkan = (int) ($pemesanan->jumlah_jip ?? 1);

                    // Ambil jip tersedia
                    $jipsTersedia = Jip::where('status', 'tersedia')
                        ->orderBy('last_used_at', 'asc')
                        ->orderBy('id', 'asc')
                        ->limit($jumlahDibutuhkan)
                        ->lockForUpdate()
                        ->get();

                    // Jika jip belum cukup, jangan lanjut
                    if ($jipsTersedia->count() < $jumlahDibutuhkan) {
                        $waktuTersedia = AlokasiJip::whereIn('jip_id', Jip::pluck('id'))
                            ->orderBy('waktu_selesai', 'asc')
                            ->value('waktu_selesai');

                        if ($waktuTersedia) {
                            $waktuMulai = Carbon::parse($waktuTersedia)->copy();
                            $durasi = (int) ($pemesanan->paketWisata->durasi ?? 60);
                            $waktuSelesai = (clone $waktuMulai)->addMinutes($durasi);

                            DB::commit();
                            sleep(1);
                            continue;
                        } else {
                            DB::rollBack();
                            return "Tidak cukup jip tersedia, proses FCFS dihentikan.";
                        }
                    } else {
                        // Hitung waktu mulai dan selesai
                        $jam = Carbon::parse($pemesanan->jam_berangkat)->format('H:i');
                        $tanggal = Carbon::parse($pemesanan->tanggal_berangkat)->format('Y-m-d');
                        $waktuBerangkatAsli = Carbon::parse("{$tanggal} {$jam}", 'Asia/Jakarta');


                        $now = Carbon::now('Asia/Jakarta');
                        if ($now->gt($waktuBerangkatAsli)) {
                            $waktuMulai = $now->copy();
                        } else {
                            $waktuMulai = $waktuBerangkatAsli->copy();
                        }

                        $durasi = (int) ($pemesanan->paketWisata->durasi ?? 60);
                        $waktuSelesai = (clone $waktuMulai)->addMinutes($durasi);
                    }

                    // Cek apakah sudah mendekati waktu berangkat
                    $now = Carbon::now('Asia/Jakarta');
                    $bufferMenit = 1;

                    if ($now->lt((clone $waktuMulai)->subMinutes($bufferMenit))) {
                        DB::rollBack();
                        continue;
                    }

                    if ($jipsTersedia->isEmpty()) {
                        DB::rollBack();
                        continue;
                    }

                    // Simpan alokasi dan ubah status jip secara atomic
                    foreach ($jipsTersedia as $jip) {
                        AlokasiJip::create([
                            'antrean_id' => $antrean->id,
                            'jip_id' => $jip->id,
                            'waktu_mulai' => $waktuMulai,
                            'waktu_selesai' => $waktuSelesai,
                        ]);

                        $jip->tandaiDigunakan();
                        $jip->update(['last_used_at' => Carbon::now('Asia/Jakarta')]);
                    }

                    // Update antrean
                    $antrean->update([
                        'status' => 'sedang dilayani',
                        'waktu_mulai' => $waktuMulai,
                        'waktu_selesai' => $waktuSelesai,
                    ]);

                    DB::commit();
                    $counter++;
                } catch (\Throwable $e) {
                    DB::rollBack();
                    Log::error('Kesalahan transaksi FCFS: ' . $e->getMessage());
                    continue;
                }
            }

            return "Proses alokasi antrean FCFS selesai.";
        } catch (\Exception $e) {
            Log::error('Kesalahan FCFSService: ' . $e->getMessage());
            return 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }

    /**
     * Update otomatis antrean yang sudah selesai
     */
    public function updateAntreanSelesaiOtomatis()
    {
        try {
            $now = Carbon::now('Asia/Jakarta');

            DB::beginTransaction();

            // Ambil antrean yang sudah selesai
            $antreans = Antrean::where('status', 'sedang dilayani')
                ->where('waktu_selesai', '<=', $now)
                ->get();

            $count = 0;
            foreach ($antreans as $antrean) {
                $antrean->update(['status' => 'selesai']);

                // Ubah status jip jadi tersedia lagi
                foreach ($antrean->alokasiJip as $alokasi) {
                    $jip = $alokasi->jip;
                    if ($jip) {
                        $jip->tandaiTersedia();
                    }
                }
                $count++;
            }

            DB::commit();
            return 'Status antrean selesai diperbarui otomatis.';
        } catch (\Exception $e) {
            Log::error('Kesalahan updateAntreanSelesaiOtomatis: ' . $e->getMessage());
            return 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }
}
