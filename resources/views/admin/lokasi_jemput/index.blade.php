@extends('layouts.admin')

@section('title', 'Kelola Lokasi Jemput')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 fw-bold">Kelola Lokasi Jemput</h2>

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
                        <i class="fas fa-map-pin me-1"></i>
                        Lokasi Jemput
                    </span>
                </li>
            </ol>
        </nav>
    </div>

    {{-- Tombol Tambah --}}
    <div class="mb-3">
        <a href="{{ route('admin.lokasi-jemput.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Tambah Lokasi Jemput
        </a>
    </div>

    {{-- Tabel Data --}}
    <div class="card shadow-lg rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive rounded">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Lokasi</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lokasis as $lokasi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lokasi->nama_lokasi }}</td>
                                <td>
                                    <a href="{{ route('admin.lokasi-jemput.edit', $lokasi->id) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.lokasi-jemput.destroy', $lokasi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?')">
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
                                <td colspan="3" class="text-center text-muted">Belum ada data lokasi jemput.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
