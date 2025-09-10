@extends('layouts.app')

@section('title', 'Bukti Pemesanan | Telomoyo Jip Explore')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/bukti-pemesananstyle.css') }}">
@endpush

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-4 card-custom">
        <div class="card-header">
            <h2 class="text-center fw-bold text-danger-emphasis m-2"> Bukti Pemesanan</h2>
        </div>
        <div class="card-body p-4">
            <table class="table table-bordered table-hover table-striped table-custom align-middle">
                <tr>
                    <th><i class="bi bi-person-circle text-danger-emphasis"></i> Nama Lengkap</th>
                    <td>{{ $pemesanan->nama }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-telephone-fill text-danger-emphasis"></i> No. Telepon</th>
                    <td>{{ $pemesanan->telepon }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-calendar-event text-danger-emphasis"></i> Tanggal Berangkat</th>
                    <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_berangkat)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-people-fill text-danger-emphasis"></i> Jumlah Orang</th>
                    <td>{{ $pemesanan->jumlah_orang }} Orang</td>
                </tr>
                <tr>
                    <th><i class="bi bi-truck text-danger-emphasis"></i> Jumlah Jip</th>
                    <td>{{ $pemesanan->jumlah_jip }} Unit</td>
                </tr>
                <tr>
                    <th><i class="bi bi-geo-alt-fill text-danger-emphasis"></i> Lokasi Jemput</th>
                    <td>{{ $pemesanan->lokasiJemput->nama_lokasi }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-map text-danger-emphasis"></i> Paket Wisata</th>
                    <td>{{ $pemesanan->paketWisata->nama_paket }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-clock-fill text-danger-emphasis"></i> Jam Berangkat</th>
                    <td>{{ $pemesanan->jam_berangkat }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-cash-stack text-danger-emphasis"></i> Total Pembayaran</th>
                    <td class="fw-bold text-danger">Rp {{ number_format($pemesanan->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th><i class="bi bi-info-circle text-danger-emphasis"></i> Status</th>
                    <td>
                        @if ($pemesanan->status == 'pending')
                            <span class="badge bg-warning text-dark px-3 py-2"><i class="bi bi-hourglass-split"></i> Menunggu</span>
                        @elseif ($pemesanan->status == 'disetujui')
                            <span class="badge bg-success px-3 py-2"><i class="bi bi-check-circle"></i> Disetujui</span>
                        @elseif ($pemesanan->status == 'ditolak')
                            <span class="badge bg-danger px-3 py-2"><i class="bi bi-x-circle"></i> Ditolak</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th><i class="bi bi-image text-danger-emphasis"></i> Bukti Pembayaran</th>
                    <td>
                        @if ($pemesanan->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $pemesanan->bukti_pembayaran) }}" target="_blank">
                                <img src="{{ asset('storage/' . $pemesanan->bukti_pembayaran) }}"
                                     alt="Bukti Pembayaran" class="img-fluid rounded img-proof" style="max-height: 200px;">
                            </a>
                        @else
                            <span class="text-muted fst-italic">Belum ada bukti pembayaran</span>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Tombol Navigasi --}}
            <div class="text-center mt-4">
                <a href="{{ route('beranda') }}" class="btn btn-success btn-md px-4 shadow">
                    <i class="bi bi-house-door-fill"></i> Kembali ke Beranda
                </a>
                <a href="#" class="btn btn-outline-danger btn-md px-4 shadow ms-2">
                    <i class="bi bi-printer"></i> Cetak Bukti
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
