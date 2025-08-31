@extends('layouts.app')

@section('title', 'Paket Wisata | Telomoyo Jip Explore')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/paketstyle.css') }}">
@endpush

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-4 text-danger-emphasis display-6">Paket Wisata</h2>
    <p class="text-center text-secondary mb-5">Temukan berbagai pilihan paket seru untuk menjelajahi keindahan Gunung Telomoyo bersama jip wisata kami!</p>

    <div class="row g-4">
        @forelse ($paket_wisatas as $paket)
            <div class="col-md-4">
                <div class="card h-100 border-0 rounded-4 shadow-sm bg-white overflow-hidden position-relative">
                    <img src="{{ asset('asset/img/telomoyojip1.png') }}" class="card-img-top" alt="{{ $paket->nama_paket }}">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title fw-semibold text-dark">{{ $paket->nama_paket }}</h5>
                            <p class="card-text text-muted small">
                                <i class="bi bi-clock me-1 text-warning"></i> Durasi: {{ $paket->durasi }} menit<br>
                                <i class="bi bi-cash-coin me-1 text-success"></i> Harga:
                                <span class="text-danger fw-bold">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                            </p>
                            <p class="text-muted small">{{ \Illuminate\Support\Str::limit($paket->deskripsi, 80) }}</p>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="#" class="btn btn-outline-danger btn-sm rounded-pill px-3"
                               data-bs-toggle="modal" data-bs-target="#modalDetail{{ $paket->id }}">
                                <i class="bi bi-info-circle me-1"></i> Detail
                            </a>
                            <a href="{{ route('pemesanan.create', $paket->id) }}" class="btn btn-danger btn-sm rounded-pill px-3">
                                <i class="bi bi-cart-plus me-1"></i> Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Detail --}}
            <div class="modal fade" id="modalDetail{{ $paket->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $paket->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content rounded-4 shadow-lg border-0">

                        {{-- Gambar Header --}}
                        <div class="modal-header p-0 border-0 position-relative">
                            <img src="{{ asset('asset/img/telomoyojip1.png') }}" class="w-100 rounded-top-4" alt="Header {{ $paket->nama_paket }}">
                            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="position-absolute bottom-0 start-0 p-4 text-white" style="background: rgba(0,0,0,0.4); width: 100%;">
                                <h4 class="mb-0 fw-bold">{{ $paket->nama_paket }}</h4>
                            </div>
                        </div>

                        {{-- Isi Deskripsi --}}
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <p><i class="bi bi-clock text-warning me-2"></i><strong>Durasi:</strong> {{ $paket->durasi }} menit</p>
                                <p><i class="bi bi-cash-coin text-success me-2"></i><strong>Harga:</strong> Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-muted"><i class="bi bi-info-circle me-2 text-secondary"></i> {{ $paket->deskripsi }}</p>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="modal-footer bg-light border-0 rounded-bottom-4 justify-content-between px-4 py-3">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                            <a href="#" class="btn btn-danger rounded-pill px-4">
                                <i class="bi bi-cart-plus me-1"></i> Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada paket wisata tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
