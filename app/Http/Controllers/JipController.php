<?php

namespace App\Http\Controllers;

use App\Models\Jip;
use Illuminate\Http\Request;

class JipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jips = Jip::with('alokasiJipAktif.antrean.pemesanan')->orderBy('id', 'asc')->paginate(10);
        return view('admin.jip.index', compact('jips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jip.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'plat_nomor' => 'required|unique:jips',
            'kapasitas' => 'required|integer|min:1',
            'driver' => 'nullable|string',
            'status' => 'required|in:tersedia,digunakan,tidak tersedia',
        ]);

        Jip::create($data);

        return redirect()->route('admin.jip.index')->with('success', 'Data jip berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $jip = Jip::findOrFail($id);

        // Ambil tanggal dari input (jika tidak ada, default = hari ini)
        $tanggal = $request->input('tanggal', now('Asia/Jakarta')->toDateString());

        // Query alokasi jip untuk tanggal yang dipilih
        $query = $jip->alokasiJip()
            ->with(['antrean.pemesanan.paketWisata'])
            ->whereDate('waktu_mulai', $tanggal);

        $riwayat = $query->orderBy('waktu_mulai', 'desc')->get();

        // Total semua pemesanan jip ini (seluruh waktu)
        $totalPemesanan = $jip->alokasiJip()->count();

        // Total pemesanan khusus hari ini
        $hariIni = now('Asia/Jakarta')->toDateString();
        $pemesananHariIni = $jip->alokasiJip()
            ->whereDate('waktu_mulai', $hariIni)
            ->count();

        return view('admin.jip.show', compact(
            'jip',
            'riwayat',
            'totalPemesanan',
            'pemesananHariIni',
            'tanggal'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jip = Jip::findOrFail($id);
        return view('admin.jip.edit', compact('jip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jip = Jip::findOrFail($id);

        $request->validate([
            'plat_nomor' => 'required|unique:jips,plat_nomor,' . $id,
            'kapasitas' => 'required|integer|min:1',
            'driver' => 'nullable|string',
            'status' => 'required|in:tersedia,digunakan,tidak tersedia',
        ]);

        $jip->update($request->only(['plat_nomor', 'kapasitas', 'driver', 'status']));

        return redirect()->route('admin.jip.index')->with('success', 'Data jip berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jip = Jip::findOrFail($id);
        $jip->delete();

        return redirect()->route('admin.jip.index')->with('success', 'Data jip berhasil dihapus');
    }
}
