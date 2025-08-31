@extends('layouts.admin')

@section('title', 'Tambah Paket Wisata')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <h2 class="mb-3">Tambah Paket Wisata</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('paket-wisata.index') }}">Paket Wisata</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

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

            <form action="{{ route('paket-wisata.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_paket" class="form-label">Nama Paket</label>
                    <input type="text" name="nama_paket" class="form-control @error('nama_paket') is-invalid @enderror" value="{{ old('nama_paket') }}" required>
                    @error('nama_paket')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="durasi" class="form-label">Durasi (menit)</label>
                    <input type="number" name="durasi" class="form-control @error('durasi') is-invalid @enderror" value="{{ old('durasi') }}" required>
                    @error('durasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" required>
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
                <a href="{{ route('paket-wisata.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
