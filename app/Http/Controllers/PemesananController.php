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

            $pemesanan->update([
                'status' => $request->status,
                'approved_by' => Auth::id(),
            ]);

            if ($request->status === 'ditolak' && $pemesanan->antrean) {
                $pemesanan->antrean->delete();
            }

            if ($request->status === 'disetujui' && !$pemesanan->antrean) {
                [$waktuMulai, $waktuSelesai] = $this->getWaktuMulaiOtomatis($pemesanan);
                $tanggal = Carbon::parse($pemesanan->tanggal_berangkat)->format('ymd');
                $lastAntrean = Antrean::where('nomor_antrean', 'like', $tanggal . '%')
                    ->orderBy('nomor_antrean', 'desc')
                    ->first();
                $nextNumber = $lastAntrean ? ((int) substr($lastAntrean->nomor_antrean, -3) + 1) : 1;
                $nomorAntrean = $tanggal . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                Antrean::create([
                    'pemesanan_id' => $pemesanan->id,
                    'nomor_antrean' => $nomorAntrean,
                    'status' => 'menunggu',
                    'waktu_mulai' => $waktuMulai,
                    'waktu_selesai' => $waktuSelesai,
                ]);
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
            'jam_berangkat' => 'required|date_format:H:i',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $jumlah_jip = ceil($request->jumlah_orang / 4);
        $paket = PaketWisata::findOrFail($request->paket_id);
        $total = $jumlah_jip * $paket->harga;

        try {
            $pemesanan = DB::transaction(function () use ($request, $jumlah_jip, $paket, $total) {

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

                // Tentukan nomor antrean langsung
                $tanggal = Carbon::parse($pemesanan->tanggal_berangkat)->format('ymd');
                $lastAntrean = Antrean::where('nomor_antrean', 'like', $tanggal . '%')
                    ->orderBy('nomor_antrean', 'desc')
                    ->first();

                $nextNumber = $lastAntrean ? ((int) substr($lastAntrean->nomor_antrean, -3) + 1) : 1;
                $nomorAntrean = $tanggal . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                [$waktuMulai, $waktuSelesai] = app(self::class)->getWaktuMulaiOtomatis($pemesanan);

                Antrean::create([
                    'pemesanan_id' => $pemesanan->id,
                    'nomor_antrean' => $nomorAntrean,
                    'status' => 'menunggu',
                    'waktu_mulai' => $waktuMulai,
                    'waktu_selesai' => $waktuSelesai,
                ]);

                return $pemesanan;
            });
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
        return redirect()->route('pemesanan.show', ['id' => $pemesanan->id])
            ->with('success', 'Pemesanan berhasil! Simpan bukti pemesanan Anda.');
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
            'jam_berangkat' => 'required|date_format:H:i',
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

            // Ambil nomor antrean terakhir berdasarkan tanggal
            $lastAntrean = Antrean::where('nomor_antrean', 'like', $tanggal . '%')
                ->orderBy('nomor_antrean', 'desc')
                ->first();

            $nextNumber = $lastAntrean ? ((int) substr($lastAntrean->nomor_antrean, -3) + 1) : 1;
            $nomorAntrean = $tanggal . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            [$waktuMulai, $waktuSelesai] = $this->getWaktuMulaiOtomatis($pemesanan);

            Antrean::create([
                'pemesanan_id' => $pemesanan->id,
                'nomor_antrean' => $nomorAntrean,
                'status' => 'menunggu',
                'waktu_mulai' => $waktuMulai,
                'waktu_selesai' => $waktuSelesai,
            ]);
        });

        return redirect()->route('admin.pemesanan.index')->with('success', 'Pemesanan berhasil ditambahkan.');
    }

    private function getWaktuMulaiOtomatis(Pemesanan $pemesanan)
    {
        $tanggal = Carbon::parse($pemesanan->tanggal_berangkat)->format('Y-m-d');
        $jam = $pemesanan->jam_berangkat ?? '00:00';
        $waktuMulai = Carbon::parse("{$tanggal} {$jam}", 'Asia/Jakarta');

        $durasi = (int) ($pemesanan->paketWisata->durasi ?? 60);
        $waktuSelesai = (clone $waktuMulai)->addMinutes($durasi);

        $totalJip = Jip::count();
        $maxIterasi = 60;
        $iterasi = 0;

        while ($iterasi < $maxIterasi) {
            $iterasi++;

            // Hitung total jip yang sedang aktif pada waktu yang sama
            $jipTerpakai = Antrean::whereHas('pemesanan', function ($q) use ($tanggal) {
                $q->whereDate('tanggal_berangkat', $tanggal);
            })
                ->where(function ($q) use ($waktuMulai, $waktuSelesai) {
                    $q->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                        ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai])
                        ->orWhere(function ($query) use ($waktuMulai, $waktuSelesai) {
                            $query->where('waktu_mulai', '<', $waktuMulai)
                                ->where('waktu_selesai', '>', $waktuSelesai);
                        });
                })
                ->with('pemesanan')
                ->get()
                ->sum(fn($a) => $a->pemesanan->jumlah_jip);

            // Jika jip masih cukup → waktu ini dipakai
            if (($jipTerpakai + $pemesanan->jumlah_jip) <= $totalJip) {
                return [$waktuMulai, $waktuSelesai];
            }

            $antreanTerakhir = Antrean::whereHas('pemesanan', function ($q) use ($tanggal) {
                $q->whereDate('tanggal_berangkat', $tanggal);
            })
                ->orderBy('waktu_selesai', 'asc')
                ->first();

            if ($antreanTerakhir) {
                $waktuMulai = Carbon::parse($antreanTerakhir->waktu_selesai)->addMinute();
                $waktuSelesai = (clone $waktuMulai)->addMinutes($durasi);
            } else {
                break;
            }
        }

        return [$waktuMulai, $waktuSelesai];
    }
}
