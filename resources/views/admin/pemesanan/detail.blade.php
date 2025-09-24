@extends('layouts.admin')

@section('title', 'Detail Pemesanan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/detailpemesananstyle.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 fw-bold">Detail Pemesanan</h2>

    {{-- Breadcrumb --}}
    <div class="bg-light rounded-3 shadow-sm p-3 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-muted fw-medium text-decoration-none">
                        <i class="fas fa-tachometer-alt me-1"></i>
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.paket-wisata.index') }}" class="text-muted fw-medium text-decoration-none">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        Paket Wisata
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-primary fw-medium">
                        <i class="fas fa-detail me-1"></i>
                        Detail Pemesanan
                    </span>
                </li>
            </ol>
        </nav>
    </div>

    {{-- Card Detail --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-info-circle me-1"></i> Informasi Pemesanan
        </div>
        <div class="card-body">

            <table class="table table-bordered detail-table">
                <tr>
                    <th style="width: 200px;">Nama</th>
                    <td>{{ $pemesanan->nama }}</td>
                </tr>
                <tr>
                    <th>Telepon</th>
                    <td>{{ $pemesanan->telepon }}</td>
                </tr>
                <tr>
                    <th>Paket Wisata</th>
                    <td>{{ $pemesanan->paketWisata->nama_paket ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Lokasi Jemput</th>
                    <td>{{ $pemesanan->lokasiJemput->nama_lokasi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Berangkat</th>
                    <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_berangkat)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Jam Berangkat</th>
                    <td>{{ $pemesanan->jam_berangkat }}</td>
                </tr>
                <tr>
                    <th>Jumlah Orang</th>
                    <td>{{ $pemesanan->jumlah_orang }} orang</td>
                </tr>
                <tr>
                    <th>Jumlah Jip</th>
                    <td>{{ $pemesanan->jumlah_jip }}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>Rp {{ number_format($pemesanan->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Bukti Pembayaran</th>
                    <td>
                        @if ($pemesanan->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $pemesanan->bukti_pembayaran) }}" target="_blank">
                                <img src="{{ asset('storage/' . $pemesanan->bukti_pembayaran) }}"
                                     alt="Bukti Pembayaran"
                                     class="img-thumbnail"
                                     style="max-width: 200px;">
                            </a>
                        @else
                            <span class="text-muted">Belum ada</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($pemesanan->status == 'pending')
                            <span class="status-badge bg-warning text-dark"><i class="fas fa-clock"></i> Menunggu</span>
                        @elseif ($pemesanan->status == 'disetujui')
                            <span class="status-badge bg-success text-white"><i class="fas fa-check-circle"></i> Disetujui</span>
                        @elseif ($pemesanan->status == 'ditolak')
                            <span class="status-badge bg-danger text-white"><i class="fas fa-times-circle"></i> Ditolak</span>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Form Update Status --}}
            <form action="{{ route('admin.pemesanan.updateStatus', $pemesanan->id) }}" method="POST" class="status-form mt-3">
                @csrf
                @method('PUT')
                <div class="status-actions">
                    <button name="status" value="disetujui" class="btn btn-success">
                        <i class="fas fa-check"></i> Setujui
                    </button>
                    <button name="status" value="ditolak" class="btn btn-danger">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                    <button name="status" value="pending" class="btn btn-warning text-dark">
                        <i class="fas fa-clock"></i> Pending
                    </button>
                </div>
            </form>

            <div class="back-btn">
                <a href="{{ route('admin.pemesanan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
