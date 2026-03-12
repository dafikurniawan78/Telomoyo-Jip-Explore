<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use Illuminate\Http\Request;

class AnalisisFCFSController extends Controller
{
    public function index(Request $request)
    {
        $tanggalFilter = $request->get('tanggalFilter'); // 'today', 'custom', atau null
        $customDate = $request->get('customDate'); // tanggal khusus jika 'custom'

        // Query dasar
        $query = Antrean::join('pemesanans', 'antreans.pemesanan_id', '=', 'pemesanans.id')
            ->join('paket_wisatas', 'pemesanans.paket_id', '=', 'paket_wisatas.id')
            ->whereIn('antreans.status', ['sedang dilayani', 'selesai']);

        // Filter tanggal opsional
        if ($tanggalFilter === 'today') {
            $query->whereDate('pemesanans.tanggal_berangkat', now()->toDateString());
        } elseif ($tanggalFilter === 'custom' && $customDate) {
            $query->whereDate('pemesanans.tanggal_berangkat', $customDate);
        }

        // Urutan FCFS
        $data = $query
            ->orderBy('antreans.waktu_mulai', 'asc')
            ->select(
                'antreans.waktu_mulai',
                'antreans.waktu_selesai',
                'pemesanans.created_at',
                'pemesanans.tanggal_berangkat',
                'pemesanans.jam_berangkat',
                'paket_wisatas.nama_paket',
                'pemesanans.payment_status',
                'pemesanans.jumlah_jip'
            )
            ->paginate(15)
            ->withQueryString();

        // Nomor global
        $startUrutan = ($data->currentPage() - 1) * $data->perPage();
        foreach ($data as $index => $row) {
            $row->urutan_proses = $startUrutan + $index + 1;
        }

        return view('admin.analisis_fcfs.index', compact('data', 'tanggalFilter', 'customDate'));
    }
}
