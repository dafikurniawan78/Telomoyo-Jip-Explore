<?php

namespace App\Http\Controllers;

use App\Models\LokasiJemput;
use Illuminate\Http\Request;
use App\Models\PaketWisata;
use App\Models\Pemesanan;

class PemesananController extends Controller
{
    public function create($id)
    {
        $paket = PaketWisata::findOrFail($id);
        $lokasi_jemputs = LokasiJemput::orderBy('id', 'asc')->get();
        return view('pages.pemesanan', compact('paket', 'lokasi_jemputs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'tanggal_berangkat' => 'required|date',
            'jumlah_orang' => 'required|integer|min:1',
            'jumlah_jip' => 'required|integer|min:1',
            'lokasi_jemput' => 'required|string|max:255',
            'paket_id' => 'required|exists:paket_wisata,id',
            'total' => 'required|integer|min:0',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil paket untuk hitung total berdasarkan harga asli
        $paket = PaketWisata::findOrFail($request->paket_id);
        $total = $request->jumlah_jip * $paket->harga;

        // Simpan data pemesanan
        Pemesanan::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'jumlah_orang' => $request->jumlah_orang,
            'jumlah_jip' => $request->jumlah_jip,
            'lokasi_jemput' => $request->lokasi_jemput,
            'paket_id' => $paket->id,
            'total' => $total,
            'bukti_pembayaran' => $request->file('bukti_pembayaran')->store('bukti', 'public'),
        ]);

        return redirect()->route('beranda')->with('success', 'Pemesanan berhasil dilakukan!');
    }
}
