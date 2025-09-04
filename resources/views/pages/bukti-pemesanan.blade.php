@extends('layouts.app')

@section('title', 'Bukti Pemesanan | Telomoyo Jip Explore')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-5 text-success">Bukti Pemesanan</h2>

    <div class="card shadow-lg rounded-4">
        <div class="card-body p-4">
            {{-- Informasi Pemesanan --}}
            <h4 class="fw-bold text-danger-emphasis">Detail Pemesanan</h4>
            <table class="table table-bordered mt-3">
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $pemesanan->nama }}</td>
                </tr>
                <tr>
                    <th>No. Telepon</th>
                    <td>{{ $pemesanan->telepon }}</td>
                </tr>
                <tr>
                    <th>Tanggal Berangkat</th>
                    <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_berangkat)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Jumlah Orang</th>
                    <td>{{ $pemesanan->jumlah_orang }} Orang</td>
                </tr>
                <tr>
                    <th>Jumlah Jip</th>
                    <td>{{ $pemesanan->jumlah_jip }} Unit</td>
                </tr>
                <tr>
                    <th>Lokasi Jemput</th>
                    <td>{{ $pemesanan->lokasiJemput->nama_lokasi }}</td>
                </tr>
                <tr>
                    <th>Paket Wisata</th>
                    <td>{{ $pemesanan->paketWisata->nama_paket }}</td>
                </tr>
                <tr>
                    <th>Jam Berangkat</th>
                    <td>{{ $pemesanan->jam_berangkat }}</td>
                </tr>
                <tr>
                    <th>Total Pembayaran</th>
                    <td><strong>Rp {{ number_format($pemesanan->total, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge bg-warning text-dark">
                            {{ ucfirst($pemesanan->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Bukti Pembayaran</th>
                    <td>
                        <a href="{{ asset('storage/' . $pemesanan->bukti_pembayaran) }}" target="_blank">
                            <img src="{{ asset('storage/' . $pemesanan->bukti_pembayaran) }}"
                                 alt="Bukti Pembayaran" class="img-fluid rounded" style="max-height: 200px;">
                        </a>
                    </td>
                </tr>
            </table>

            {{-- Tombol --}}
            <div class="text-center mt-4">
                <a href="{{ route('beranda') }}" class="btn btn-success shadow">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
