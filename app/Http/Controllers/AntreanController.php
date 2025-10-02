<?php

namespace App\Http\Controllers;

use App\Models\AlokasiJip;
use App\Models\Antrean;
use Illuminate\Http\Request;

class AntreanController extends Controller
{
    public function index()
    {
        $antreans = Antrean::with('pemesanan')->orderBy('nomor_antrean', 'asc')->paginate(10);
        return view('admin.antrean.index', compact('antreans'));
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

    public function destroy($id)
    {
        $antrean = Antrean::findOrFail($id);

        $alokasi = AlokasiJip::with('jip')->where('antrean_id', $antrean->id)->first();
        if ($alokasi) {
            $alokasi->jip->update(['status' => 'tersedia']);
            $alokasi->delete();
        }

        $antrean->delete();

        return redirect()->route('admin.antrean.index')->with('success', 'Antrean berhasil dihapus');
    }
}
