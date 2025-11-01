<?php

namespace App\Http\Controllers;

use App\Models\AlokasiJip;
use App\Models\Antrean;
use App\Models\LokasiJemput;
use App\Models\PaketWisata;
use App\Models\Pemesanan;
use App\Models\Jip;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;


class PemesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = Pemesanan::with(['paketWisata', 'lokasiJemput'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $pemesanans = $query->paginate(10);

        return view('admin.pemesanan.index', compact('pemesanans', 'status'));
    }

    public function detail($id)
    {
        $pemesanan = Pemesanan::with(['paketWisata', 'lokasiJemput'])->findOrFail($id);
        return view('admin.pemesanan.detail', compact('pemesanan'));
    }

    public function updateStatus(Request $request, Pemesanan $pemesanan)
    {
        $request->validate([
            'status' => 'required|in:pending,disetujui,ditolak'
        ]);

        DB::transaction(function () use ($request, $pemesanan) {

            //Update status pemesanan
            $pemesanan->update([
                'status' => $request->status,
                'approved_by' => Auth::id(),
            ]);

            if ($request->status === 'disetujui') {
                $antrean = $pemesanan->antrean;

                if (!$antrean) {
                    $tanggal = Carbon::parse($pemesanan->tanggal_berangkat)->format('ymd');

                    $pemesanansTanggalIni = Pemesanan::whereDate('tanggal_berangkat', $pemesanan->tanggal_berangkat)
                        ->orderBy('created_at', 'asc')
                        ->lockForUpdate()
                        ->get();

                    $urutan = 1;
                    foreach ($pemesanansTanggalIni as $p) {
                        if ($p->antrean) continue;
                        if ($p->id === $pemesanan->id) break;
                        $urutan++;
                    }

                    $nomorAntrean = $tanggal . str_pad($urutan, 3, '0', STR_PAD_LEFT);

                    Antrean::create([
                        'pemesanan_id' => $pemesanan->id,
                        'nomor_antrean' => $nomorAntrean,
                        'status' => 'menunggu',
                    ]);
                }
            }
        });

        return redirect()->route('admin.pemesanan.index')->with('success', 'Status pemesanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->bukti_pembayaran) {
            Storage::disk('public')->delete($pemesanan->bukti_pembayaran);
        }


        $pemesanan->delete();

        return redirect()->route('admin.pemesanan.index')->with('success', 'Data pemesanan berhasil dihapus.');
    }


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
            'telepon' => 'required|regex:/^[0-9]{9,13}$/',
            'tanggal_berangkat' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addYear()->format('Y-m-d'),
            'jumlah_orang' => 'required|integer|min:1',
            'lokasi_jemput_id' => 'required|exists:lokasi_jemputs,id',
            'paket_id' => 'required|exists:paket_wisatas,id',
            'jam_berangkat' => 'required|string',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Hitung jumlah jip ulang berdasarkan jumlah orang
        $jumlah_jip = ceil($request->jumlah_orang / 4);

        // Ambil paket untuk hitung total berdasarkan harga asli
        $paket = PaketWisata::findOrFail($request->paket_id);
        $total = $jumlah_jip * $paket->harga;

        // Simpan data pemesanan
        $pemesanan = Pemesanan::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'jumlah_orang' => $request->jumlah_orang,
            'jumlah_jip' => $jumlah_jip,
            'lokasi_jemput_id' => $request->lokasi_jemput_id,
            'paket_id' => $paket->id,
            'jam_berangkat' => $request->jam_berangkat,
            'total' => $total,
            'status' => 'pending',
            'bukti_pembayaran' => $request->file('bukti_pembayaran')->store('bukti', 'public'),
        ]);

        return redirect()->route('pemesanan.show', $pemesanan->id)->with('success', 'Pemesanan berhasil! Simpan bukti pemesanan Anda.');
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::with('paketWisata', 'lokasiJemput')->findOrFail($id);
        return view('pages.bukti-pemesanan', compact('pemesanan'));
    }

    public function cetak($id)
    {
        $pemesanan = Pemesanan::with(['paketWisata', 'lokasiJemput'])->findOrFail($id);

        // Custom size tiket: 20cm x 7cm (portrait)
        $width = 20 * 28.35; // 567 pt
        $height = 7 * 28.35; // 198 pt
        $customPaper = [0, 0, $width, $height];

        $pdf = Pdf::loadView('pdf.tiket', compact('pemesanan'))
            ->setPaper($customPaper, 'portrait');

        return $pdf->download('Tiket-Pemesanan-' . $pemesanan->id . '.pdf');
    }

    public function createAdmin()
    {
        $pakets = PaketWisata::all();
        $lokasi_jemputs = LokasiJemput::all();

        return view('admin.pemesanan.create', compact('pakets', 'lokasi_jemputs'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:15',
            'tanggal_berangkat' => 'required|date|after_or_equal:today',
            'jumlah_orang' => 'required|integer|min:1',
            'lokasi_jemput_id' => 'required|exists:lokasi_jemputs,id',
            'paket_id' => 'required|exists:paket_wisatas,id',
            'jam_berangkat' => 'required',
            'total' => 'required|numeric',
            'bukti_pembayaran' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['telepon'] = $request->telepon ?? '-';
        $data['jumlah_jip'] = ceil($request->jumlah_orang / 4);
        $data['status'] = 'disetujui';
        $data['approved_by'] = Auth::id();

        if ($request->hasFile('bukti_pembayaran')) {
            $data['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        DB::transaction(function () use ($data) {

            $pemesanan = Pemesanan::create($data);

            $tanggal = Carbon::parse($pemesanan->tanggal_berangkat)->format('ymd');

            $pemesanansTanggalIni = Pemesanan::whereDate('tanggal_berangkat', $pemesanan->tanggal_berangkat)
                ->orderBy('created_at', 'asc')
                ->lockForUpdate()
                ->get();

            $urutan = 1;
            foreach ($pemesanansTanggalIni as $p) {
                if ($p->antrean) continue;
                if ($p->id === $pemesanan->id) break;
                $urutan++;
            }

            $nomorAntrean = $tanggal . str_pad($urutan, 3, '0', STR_PAD_LEFT);

            Antrean::create([
                'pemesanan_id' => $pemesanan->id,
                'nomor_antrean' => $nomorAntrean,
                'status' => 'menunggu',
            ]);
        });

        return redirect()->route('admin.pemesanan.index')->with('success', 'Pemesanan berhasil ditambahkan.');
    }
}
