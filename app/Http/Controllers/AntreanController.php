<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AntreanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalFilter = $request->get('tanggal');
        $customDate = $request->get('custom_date');

        $query = Antrean::with(['pemesanan.paketWisata'])->orderBy('nomor_antrean', 'asc');

        if ($tanggalFilter === 'today') {
            $query->whereHas('pemesanan', function ($q) {
                $q->whereDate('tanggal_berangkat', now()->toDateString());
            });
        } elseif ($tanggalFilter === 'custom' && $customDate) {
            $query->whereHas('pemesanan', function ($q) use ($customDate) {
                $q->whereDate('tanggal_berangkat', $customDate);
            });
        }

        $antreans = $query->paginate(10);

        foreach ($antreans as $antrean) {
            if ($antrean->pemesanan && $antrean->waktu_mulai && $antrean->waktu_selesai) {
                $created = Carbon::parse($antrean->pemesanan->created_at);
                $waktuMulai = Carbon::parse($antrean->waktu_mulai);
                $waktuSelesai = Carbon::parse($antrean->waktu_selesai);

                // Hitung waktu tunggu & turnaround
                $waitingTime = round($created->diffInMinutes($waktuMulai));
                $turnaroundTime = round($created->diffInMinutes($waktuSelesai));

                $hour = $waktuMulai->hour;
                if ($hour >= 4 && $hour < 11) {
                    $sesi = 'Pagi';
                } elseif ($hour >= 11 && $hour < 14) {
                    $sesi = 'Siang';
                } elseif ($hour >= 14 && $hour <= 16) {
                    $sesi = 'Sore';
                } else {
                    $sesi = 'Di luar jam operasional';
                }

                $antrean->setAttribute('waiting_time', $waitingTime);
                $antrean->setAttribute('turnaround_time', $turnaroundTime);
                $antrean->setAttribute('sesi_waktu', $sesi);
            } else {
                $antrean->setAttribute('waiting_time', null);
                $antrean->setAttribute('turnaround_time', null);
                $antrean->setAttribute('sesi_waktu', null);
            }
        }

        return view('admin.antrean.index', compact('antreans', 'tanggalFilter', 'customDate'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,sedang dilayani,selesai',
        ]);

        $antrean = Antrean::with('pemesanan')->findOrFail($id);
        $statusLama = $antrean->status;
        $statusBaru = $request->status;

        $antrean->status = $statusBaru;

        // Jika status berubah jadi "selesai"
        if ($statusBaru === 'selesai' && $statusLama !== 'selesai') {
            $waktuMulai = $antrean->waktu_mulai ?? now();
            $waktuSelesai = now();

            $antrean->waktu_selesai = $waktuSelesai;

            // Hitung waktu tunggu & total berdasarkan urutan benar
            $waitingTime = $waktuMulai->diffInMinutes($antrean->pemesanan->created_at);
            $turnaroundTime = $waktuSelesai->diffInMinutes($antrean->pemesanan->created_at);

            $antrean->waiting_time = $waitingTime;
            $antrean->turnaround_time = $turnaroundTime;
        }

        $antrean->save();

        return redirect()
            ->route('admin.antrean.index')
            ->with('success', 'Status antrean berhasil diperbarui.');
    }

    public function formCek()
    {
        return view('pages.cek-antrean');
    }

    public function cekStatus(Request $request)
    {
        $request->validate([
            'nomor_antrean' => 'required'
        ]);

        $antrean = Antrean::with('pemesanan')
            ->where('nomor_antrean', $request->nomor_antrean)
            ->first();

        if (!$antrean) {
            return back()->with('error', 'Nomor antrean tidak ditemukan');
        }

        if ($antrean->waktu_mulai) {

            $estimasiMulai = $antrean->waktu_mulai;
            $estimasiSelesai = $antrean->waktu_selesai;

            $sisaWaktu = max(0, (int) now()->diffInMinutes($estimasiMulai, false));
        } else {

            $jumlahSebelum = Antrean::whereHas('pemesanan', function ($q) use ($antrean) {
                $q->whereDate(
                    'tanggal_berangkat',
                    $antrean->pemesanan->tanggal_berangkat
                );
            })
                ->where('status', 'menunggu')
                ->where('nomor_antrean', '<', $antrean->nomor_antrean)
                ->count();

            $durasi = 15;

            $estimasiMulai = now()->addMinutes($jumlahSebelum * $durasi);
            $estimasiSelesai = $estimasiMulai->copy()->addMinutes($durasi);

            $sisaWaktu = max(0, (int) now()->diffInMinutes($estimasiMulai, false));
        }


        return view('pages.cek-antrean', compact(
            'antrean',
            'estimasiMulai',
            'estimasiSelesai',
            'sisaWaktu'
        ));
    }
}
