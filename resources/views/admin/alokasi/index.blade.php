@extends('layouts.admin')

@section('title', 'Data Alokasi Jip')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <h2 class="mb-3">Data Alokasi Jip</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Alokasi</li>
        </ol>
    </nav>

    {{-- Tabel Data Alokasi --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
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
                    @forelse ($alokasis as $alokasi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $alokasi->antrean->pemesanan->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($alokasi->antrean->pemesanan->tanggal_berangkat)->format('d-m-Y') }}</td>
                            <td>{{ $alokasi->antrean->pemesanan->paketWisata->nama_paket ?? '-' }}</td>
                            <td>{{ $alokasi->antrean->pemesanan->jumlah_orang }} org</td>
                            <td>{{ $alokasi->antrean->pemesanan->jumlah_jip }}</td>
                            <td>{{ $alokasi->antrean->pemesanan->lokasiJemput->nama_lokasi ?? '-' }}</td>
                            <td>{{ $alokasi->jip->plat_nomor ?? '-' }}</td>
                            <td>{{ $alokasi->waktu_mulai ? $alokasi->waktu_mulai->format('H:i d-m-Y') : '-' }}</td>
                            <td>{{ $alokasi->waktu_selesai ? $alokasi->waktu_selesai->format('H:i d-m-Y') : '-' }}</td>
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

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $alokasis->links() }}
    </div>
</div>
@endsection
