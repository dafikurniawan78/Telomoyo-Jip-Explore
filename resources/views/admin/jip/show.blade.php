@extends('layouts.admin')

@section('title', 'Detail Jip ' . $jip->plat_nomor)

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 fw-bold">
        <i class="fas fa-car me-2"></i> Detail Jip - {{ $jip->plat_nomor }}
    </h2>

    {{-- Tombol Kembali --}}
    <div class="mt-3 mb-3">
        <a href="{{ route('admin.jip.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

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
                    <a href="{{ route('admin.jip.index') }}" class="text-muted fw-medium text-decoration-none">
                        <i class="fas fa-car me-1"></i>
                        Data Jip
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-primary fw-medium">
                        <i class="fas fa-info-circle me-1"></i>
                        Detail Data
                    </span>
                </li>
            </ol>
        </nav>
    </div>

    {{-- Informasi Utama --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold">Informasi Jip</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Plat Nomor:</strong> {{ $jip->plat_nomor }}</li>
                <li class="list-group-item"><strong>Kapasitas:</strong> {{ $jip->kapasitas }} Orang</li>
                <li class="list-group-item"><strong>Driver:</strong> {{ $jip->driver ?? 'Belum ada' }}</li>
                <li class="list-group-item">
                    <strong>Status:</strong>
                    @if($jip->status == 'tersedia')
                        <span class="badge bg-success">Tersedia</span>
                    @elseif($jip->status == 'digunakan')
                        <span class="badge bg-warning text-dark">Digunakan</span>
                    @else
                        <span class="badge bg-secondary">Tidak Tersedia</span>
                    @endif
                </li>
            </ul>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold text-primary">Total Pemesanan Dilayani</h5>
                    <h3 class="fw-bolder">{{ $totalPemesanan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold text-success">Pemesanan Hari Ini</h5>
                    <h3 class="fw-bolder">{{ $pemesananHariIni }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Tanggal --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-10">
                    <label for="tanggal" class="form-label fw-semibold">Pilih Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Riwayat Pemesanan --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Riwayat Pemesanan - {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</h5>

            <div class="table-responsive rounded-3">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Pemesan</th>
                            <th>Paket Wisata</th>
                            <th>Waktu Mulai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->antrean->pemesanan->nama ?? '-' }}</td>
                                <td>{{ $data->antrean->pemesanan->paketWisata->nama_paket ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->waktu_mulai)->format('d M Y H:i') }}</td>
                                <td>
                                    <span class="badge
                                        @if($data->antrean->status == 'selesai') bg-success
                                        @elseif($data->antrean->status == 'sedang dilayani') bg-warning text-dark
                                        @else bg-secondary @endif">
                                        {{ ucfirst($data->antrean->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada pemesanan pada tanggal ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
