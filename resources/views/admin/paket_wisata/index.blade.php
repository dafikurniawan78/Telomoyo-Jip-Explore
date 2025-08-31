@extends('layouts.admin')

@section('title', 'Kelola Paket Wisata')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <h2 class="mb-3">Kelola Paket Wisata</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Paket Wisata</li>
        </ol>
    </nav>

    {{-- Tombol Tambah --}}
    <div class="mb-3">
        <a href="{{ route('paket-wisata.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Tambah Paket Wisata
        </a>
    </div>

    {{-- Tabel Data --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Paket</th>
                        <th>Durasi</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($paket_wisatas as $paket)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $paket->nama_paket }}</td>
                            <td>{{ $paket->durasi }} menit</td>
                            <td>Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($paket->deskripsi, 60) }}</td>
                            <td>
                                <a href="{{ route('paket-wisata.edit', $paket->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('paket-wisata.destroy', $paket->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data paket wisata.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
