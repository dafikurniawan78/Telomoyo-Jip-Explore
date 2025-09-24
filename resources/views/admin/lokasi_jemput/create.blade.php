@extends('layouts.admin')

@section('title', 'Tambah Lokasi Jemput')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 fw-bold">Tambah Lokasi Jemput</h2>

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
                    <a href="{{ route('admin.lokasi-jemput.index') }}" class="text-muted fw-medium text-decoration-none">
                        <i class="fas fa-map-pin me-1"></i>
                        Lokasi Jemput
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-primary fw-medium">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Data
                    </span>
                </li>
            </ol>
        </nav>
    </div>

    {{-- Form Tambah --}}
    <div class="card shadow-sm">
        <div class="card-body">
            {{-- Tampilkan error validasi jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Oops!</strong> Ada kesalahan pada input Anda:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.lokasi-jemput.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_lokasi" class="form-label">Nama Lokasi Jemput</label>
                    <input type="text" name="nama_lokasi" class="form-control @error('nama_lokasi') is-invalid @enderror"
                           value="{{ old('nama_lokasi') }}" placeholder="Masukkan nama lokasi jemput" required>
                    @error('nama_lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.lokasi-jemput.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
