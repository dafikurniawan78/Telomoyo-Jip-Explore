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

                // Ambil antrean menunggu paling awal untuk hari ini
                $antrean = Antrean::join('pemesanans', 'antreans.pemesanan_id', '=', 'pemesanans.id')
                    ->where('antreans.status', 'menunggu')
                    ->whereDate('pemesanans.tanggal_berangkat', $today)
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
                    $jumlahDibutuhkan = (int) ($pemesanan->jumlah_jip ?? 1);

                    // Ambil jip tersedia
                    $jipsTersedia = Jip::where('status', 'tersedia')
                        ->orderBy('id')
                        ->limit($jumlahDibutuhkan)
                        ->lockForUpdate()
                        ->get();

                    // Jika jip belum cukup, jangan lanjut
                    if ($jipsTersedia->count() < $jumlahDibutuhkan) {
                        DB::rollBack();
                        return "Tidak cukup jip tersedia, proses FCFS dihentikan.";
                    }

                    // Hitung waktu mulai dan selesai
                    $tanggal = Carbon::parse($pemesanan->tanggal_berangkat)->format('Y-m-d');
                    $jam = $pemesanan->jam_berangkat ?? '00:00';
                    $waktuMulai = Carbon::parse("{$tanggal} {$jam}", 'Asia/Jakarta');
                    $durasi = (int) ($pemesanan->paketWisata->durasi ?? 60);
                    $waktuSelesai = (clone $waktuMulai)->addMinutes($durasi);

                    // Cek apakah sudah mendekati waktu berangkat
                    $now = Carbon::now('Asia/Jakarta');
                    $bufferMenit = 1;

                    if ($now->lt((clone $waktuMulai)->subMinutes($bufferMenit))) {
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

                        // Ubah status jip langsung di DB (tanpa caching)
                        $jip->tandaiDigunakan();
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
