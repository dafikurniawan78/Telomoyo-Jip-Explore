@extends('layouts.admin')

@section('title', 'Data Alokasi Jip')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 fw-bold">Alokasi Jip</h2>

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
                        <i class="fas fas fa-tasks me-1"></i>
                        Alokasi
                    </span>
                </li>
            </ol>
        </nav>
    </div>

    {{-- Tabel Data Alokasi --}}
    <div class="card shadow-lg rounded">
        <div class="card-body p-0">
            <div class="table-responsive rounded">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Wisatawan</th>
                            <th>Tanggal</th>
                            <th>Paket Wisata</th>
                            <th>Jumlah Orang</th>
                            <th>Jumlah Jip</th>
                            <th>Lokasi Penjemputan</th>
                            <th>Plat Jip Dialokasikan</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($antreans as $antrean)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $antrean->pemesanan->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($antrean->pemesanan->tanggal_berangkat)->format('d-m-Y') }}</td>
                                <td>{{ $antrean->pemesanan->paketWisata->nama_paket ?? '-' }}</td>
                                <td>{{ $antrean->pemesanan->jumlah_orang }} org</td>
                                <td>{{ $antrean->pemesanan->jumlah_jip }}</td>
                                <td>{{ $antrean->pemesanan->lokasiJemput->nama_lokasi ?? '-' }}</td>
                                <td>
                                    {{ $antrean->alokasiJip->pluck('jip.plat_nomor')->join(', ') }}
                                </td>
                                <td>
                                    {{ $antrean->alokasiJip->first()?->waktu_mulai?->format('H:i d-m-Y') ?? '-' }}
                                </td>
                                <td>
                                    {{ $antrean->alokasiJip->first()?->waktu_selesai?->format('H:i d-m-Y') ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">Belum ada data alokasi jip.</td>
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
