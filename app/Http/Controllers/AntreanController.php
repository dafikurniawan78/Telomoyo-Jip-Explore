<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class AntreanController extends Controller
{
    public function index()
    {
        $antreans = Antrean::with('pemesanan')->orderBy('nomor_antrean', 'asc')->get();
        return view('admin.antrean.index', compact('antreans'));
    }

    public function storeFromPemesanan($pemesananId)
    {
        $pemesanan = Pemesanan::findOrFail($pemesananId);

        $lastNumber = Antrean::max('nomor_antrean') ?? 0;

        Antrean::create([
            'pemesanan_id' => $pemesanan->id,
            'nomor_antrean' => $lastNumber + 1,
            'status' => 'menunggu',
        ]);

        return redirect()->route('admin.antrean.index')->with('success', 'Pemesanan berhasil dimasukkan ke antrean');
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
        $antrean->delete();

        return redirect()->route('admin.antrean.index')->with('success', 'Antrean berhasil dihapus');
    }
}
