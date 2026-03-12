@extends('layouts.app')

@section('title', 'Cek Status Antrean | Telomoyo Jip Explore')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cekantreanstyle.css') }}">
@endpush

@section('content')
<div class="container py-5">

    <h2 class="text-center fw-bold mb-5 text-danger-emphasis">
        Cek Status Antrean
    </h2>

    <div class="card card-status">
        <div class="card-body p-4 p-md-5">

            {{-- Pesan Error --}}
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('cek.antrean.proses') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label">
                        Masukkan Nomor Antrean
                    </label>
                    <input type="text"
                           name="nomor_antrean"
                           class="form-control"
                           placeholder="Contoh: 202406001"
                           required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-status">
                        Cek Status
                    </button>
                </div>

            </form>

            {{-- Hasil --}}
            @if(isset($antrean))
                <div class="result-section fade-in">

                    <h5 class="text-center fw-bold mb-4 text-success">
                        Informasi Antrean Anda
                    </h5>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label">Nomor Antrean</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $antrean->nomor_antrean }}"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <input type="text"
                                class="form-control"
                                value="{{ ucfirst($antrean->status) }}"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pelayanan</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $estimasiMulai->format('d-m-Y') }}"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Waktu Menuju Keberangkatan</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $sisaWaktu }} menit lagi"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Estimasi Mulai Dilayani</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $estimasiMulai->format('H:i') }}"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Estimasi Selesai</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $estimasiSelesai->format('H:i') }}"
                                readonly>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
