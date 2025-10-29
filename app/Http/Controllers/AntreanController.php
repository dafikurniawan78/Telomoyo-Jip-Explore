<?php

namespace App\Http\Controllers;

use App\Models\AlokasiJip;
use App\Models\Antrean;
use Illuminate\Http\Request;

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

        return view('admin.antrean.index', compact('antreans', 'tanggalFilter', 'customDate'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,sedang dilayani,selesai',
        ]);

        $antrean = Antrean::findOrFail($id);

        $antrean->update([
            'status' => $request->status,
            'waktu_mulai' => $request->status == 'sedang dilayani' ? now() : $antrean->waktu_mulai,
            'waktu_selesai' => $request->status == 'selesai' ? now() : $antrean->waktu_selesai,
        ]);

        return redirect()->route('admin.antrean.index')->with('success', 'Status antrean diperbarui');
    }
}
