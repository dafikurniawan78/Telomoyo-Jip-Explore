@extends('layouts.admin')

@section('title', 'Tambah Data Jip')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <h2 class="mb-3">Tambah Data Jip</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.jip.index') }}">Data Jip</a></li>
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

            <form action="{{ route('admin.jip.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="plat_nomor" class="form-label">Plat Nomor</label>
                    <input type="text" name="plat_nomor" class="form-control @error('plat_nomor') is-invalid @enderror" value="{{ old('plat_nomor') }}" required>
                    @error('plat_nomor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" value="{{ old('kapasitas', 4) }}" required>
                    @error('kapasitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="driver" class="form-label">Nama Driver</label>
                    <input type="text" name="driver" class="form-control @error('driver') is-invalid @enderror" value="{{ old('driver') }}">
                    @error('driver')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label d-block">Status</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="statusTersedia" value="tersedia"
                            {{ old('status', 'tersedia') == 'tersedia' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="statusTersedia">Tersedia</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="statusTidak" value="tidak tersedia"
                            {{ old('status') == 'tidak tersedia' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusTidak">Tidak Tersedia</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="statusDigunakan" value="digunakan"
                            {{ old('status') == 'digunakan' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusDigunakan">Digunakan</label>
                    </div>
                    @error('status')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.jip.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
