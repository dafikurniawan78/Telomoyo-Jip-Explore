@extends('layouts.admin')

@section('title', 'Edit Data Jip')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <h2 class="mb-3">Edit Data Jip</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.jip.index') }}">Data Jip</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    {{-- Form Edit --}}
    <div class="card shadow-sm">
        <div class="card-body">
            {{-- Tampilkan error validasi --}}
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

            <form action="{{ route('admin.jip.update', $jip->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="plat_nomor" class="form-label">Plat Nomor</label>
                    <input type="text" name="plat_nomor" class="form-control @error('plat_nomor') is-invalid @enderror"
                        value="{{ old('plat_nomor', $jip->plat_nomor) }}" required>
                    @error('plat_nomor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror"
                        value="{{ old('kapasitas', $jip->kapasitas) }}" min="1" required>
                    @error('kapasitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="driver" class="form-label">Nama Driver</label>
                    <input type="text" name="driver" class="form-control @error('driver') is-invalid @enderror"
                        value="{{ old('driver', $jip->driver) }}">
                    @error('driver')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="statusTersedia"
                            value="tersedia" {{ old('status', $jip->status) == 'tersedia' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusTersedia">Tersedia</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="statusTidak"
                            value="tidak tersedia" {{ old('status', $jip->status) == 'tidak tersedia' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusTidak">Tidak Tersedia</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="statusDigunakan"
                            value="digunakan" {{ old('status', $jip->status) == 'digunakan' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusDigunakan">Digunakan</label>
                    </div>
                    @error('status')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Update
                </button>
                <a href="{{ route('admin.jip.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
