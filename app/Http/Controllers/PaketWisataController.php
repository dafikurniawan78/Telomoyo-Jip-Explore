<?php

namespace App\Http\Controllers;

use App\Models\PaketWisata;
use Illuminate\Http\Request;

class PaketWisataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paket_wisatas = PaketWisata::all();
        return view('admin.paket_wisata.index', compact('paket_wisatas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.paket_wisata.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'durasi' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
        ]);

        \App\Models\PaketWisata::create([
            'nama_paket' => $request->nama_paket,
            'durasi' => $request->durasi,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.paket-wisata.index')->with('success', 'Paket wisata berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaketWisata $paketWisata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paketWisata = PaketWisata::findOrFail($id);
        return view('admin.paket_wisata.edit', compact('paketWisata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'durasi' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
        ]);

        $paketWisata = PaketWisata::findOrFail($id);
        $paketWisata->update($request->only(['nama_paket', 'durasi', 'harga', 'deskripsi']));

        return redirect()->route('admin.paket-wisata.index')->with('success', 'Paket wisata berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paketWisata = PaketWisata::findOrFail($id);
        $paketWisata->delete();

        return redirect()->route('admin.paket-wisata.index')->with('success', 'Paket wisata berhasil dihapus.');
    }
}
