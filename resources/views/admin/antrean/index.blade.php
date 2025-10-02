@extends('layouts.admin')

@section('title', 'Kelola Antrean')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 fw-bold">Kelola Antrean</h2>

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
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-primary fw-medium">
                        <i class="fas fa-stream me-1"></i>
                        Antrean
                    </span>
                </li>
            </ol>
        </nav>
    </div>

    {{-- Tabel Antrean --}}
    <div class="card shadow-lg rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive rounded">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nomor Antrean</th>
                            <th>Nama Pemesan</th>
                            <th>Paket Wisata</th>
                            <th>Status</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($antreans as $antrean)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="fw-bold">{{ $antrean->nomor_antrean }}</span></td>
                                <td>{{ $antrean->pemesanan->nama ?? '-' }}</td>
                                <td>{{ $antrean->pemesanan->paketWisata->nama_paket ?? '-' }}</td>
                                <td>
                                    @if($antrean->status == 'menunggu')
                                        <span class="badge bg-secondary">Menunggu</span>
                                    @elseif($antrean->status == 'sedang dilayani')
                                        <span class="badge bg-warning text-dark">Sedang Dilayani</span>
                                    @else
                                        <span class="badge bg-success">Selesai</span>
                                    @endif
                                </td>
                                <td>{{ $antrean->waktu_mulai ? $antrean->waktu_mulai->format('H:i d-m-Y') : '-' }}</td>
                                <td>{{ $antrean->waktu_selesai ? $antrean->waktu_selesai->format('H:i d-m-Y') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada antrean.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $antreans->links() }}
    </div>
</div>
@endsection
