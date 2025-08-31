<?php

namespace App\Http\Controllers;

use App\Models\LokasiJemput;
use Illuminate\Http\Request;

class LokasiJemputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasis = LokasiJemput::orderBy('id', 'asc')->get();
        return view('admin.lokasi_jemput.index', compact('lokasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lokasi_jemput.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255'
        ]);

        LokasiJemput::create([
            'nama_lokasi' => $request->nama_lokasi
        ]);

        return redirect()->route('lokasi-jemput.index')->with('success', 'Lokasi jemput berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lokasi = LokasiJemput::findOrFail($id);
        return view('admin.lokasi_jemput.edit', compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255'
        ]);

        $lokasi = LokasiJemput::findOrFail($id);
        $lokasi->update([
            'nama_lokasi' => $request->nama_lokasi
        ]);

        return redirect()->route('lokasi-jemput.index')->with('success', 'Lokasi jemput berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        LokasiJemput::destroy($id);
        return redirect()->route('lokasi-jemput.index')->with('success', 'Lokasi jemput berhasil dihapus');
    }
}
