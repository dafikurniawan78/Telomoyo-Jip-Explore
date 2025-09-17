<?php

namespace App\Http\Controllers;

use App\Models\AlokasiJip;
use App\Models\Antrean;
use App\Models\Pemesanan;
use App\Models\Jip;
use Illuminate\Http\Request;

class AntreanController extends Controller
{
    public function index()
    {
        $antreans = Antrean::with('pemesanan')->orderBy('nomor_antrean', 'asc')->paginate(10);
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

    public function layani($id)
    {
        $antrean = Antrean::with('pemesanan')->findOrFail($id);

        // Cari jip yang tersedia
        $jip = Jip::where('status', 'tersedia')->first();

        if (!$jip) {
            return redirect()->route('admin.antrean.index')->with('error', 'Tidak ada jip yang tersedia saat ini.');
        }

        //Update status antrean
        $antrean->update([
            'status' => 'sedang dilayani',
            'waktu_mulai' => now(),
        ]);

        //Simpan alokasi jip
        AlokasiJip::create([
            'antrean_id' => $antrean->id,
            'jip_id' => $jip->id,
            'waktu_mulai' => now(),
        ]);

        //Update status jip
        $jip->update(['status' => 'digunakan']);

        return redirect()->route('admin.antrean.index')->with('success', 'Antrean #' . $antrean->nomor_antrean . ' sedang dilayani dengan jip ' . $jip->plat_nomor);
    }

    public function selesai($id)
    {
        $antrean = Antrean::with('pemesanan')->findOrFail($id);

        $antrean->update([
            'status' => 'selesai',
            'waktu_selesai' => now(),
        ]);

        $alokasi = AlokasiJip::with('jip')->where('antrean_id', $antrean->id)->first();
        if ($alokasi) {
            $alokasi->update(['waktu_selesai' => now()]);

            $alokasi->jip->update(['status' => 'tersedia']);
        }

        return redirect()->route('admin.antrean.index')->with('success', 'Antrean #' . $antrean->nomor_antrean . ' selesai dilayani.');
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
