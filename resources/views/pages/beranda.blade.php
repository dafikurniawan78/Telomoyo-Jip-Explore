@extends('layouts.app')

@section('title', 'Beranda | Telomoyo Jip Explore')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/berandastyle.css') }}">
@endpush

@section('content')
{{-- Hero Section --}}
<section class="hero-telomoyo d-flex align-items-center text-white" style="background-image: url('{{ asset('asset/img/hero-telomoyo2.png') }}');">
    <div class="hero-overlay"></div>
    <div class="container text-center position-relative z-1">
        <h1 class="hero-title animate__animated animate__fadeInDown">Jelajahi Keindahan Gunung Telomoyo</h1>
        <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">Naik jip, nikmati panorama, dan rasakan sensasi petualangan seru dari ketinggian!</p>
        <a href="#paket" class="btn btn-warning btn-lg px-4 mt-3 fw-semibold rounded-pill shadow-sm">Jelajahi Paket Wisata</a>
    </div>
</section>

{{-- Paket Wisata Section --}}
<div class="container py-5" id="paket">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-6 text-danger-emphasis">Paket Wisata</h2>
        <p class="text-secondary">Pilih paket terbaik untuk menjelajahi indahnya Gunung Telomoyo dengan jip wisata!</p>
    </div>

    <div class="row g-4">
        @forelse ($paket_wisatas as $paket)
        <div class="col-md-4">
            <div class="card h-100 border-0 rounded-4 shadow-sm position-relative overflow-hidden bg-white">
                <img src="{{ asset('asset/img/telomoyojip1.png') }}" class="card-img-top" alt="{{ $paket->nama_paket }}">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title fw-semibold text-dark">{{ $paket->nama_paket }}</h5>
                        <p class="card-text text-muted small">
                            <i class="bi bi-clock me-1 text-warning"></i> Durasi: {{ $paket->durasi }} menit<br>
                            <i class="bi bi-cash-coin me-1 text-success"></i> Harga:
                            <span class="text-danger fw-bold">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                        </p>
                    </div>
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
                        <a href="{{ route('pemesanan.create', $paket->id) }}" class="btn btn-danger rounded-pill px-4">
                            <i class="bi bi-cart-plus me-1"></i> Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-muted">Belum ada data paket wisata tersedia.</p>
        </div>
        @endforelse
    </div>

    {{-- Tombol Lihat Semua --}}
    <div class="text-center mt-5">
        <a href="{{ route('paket') }}" class="btn btn-outline-success btn-lg rounded-pill px-5 shadow-sm">
            <i class="bi bi-arrow-right-circle me-2"></i> Lihat Semua Paket
        </a>
    </div>
</div>

{{-- Promosi Booking --}}
<section class="promo-booking-wrapper">
    <div class="promo-booking-section">
        <div class="container">
            <div class="row align-items-center">
                {{-- Deskripsi --}}
                <div class="col-md-6 mb-4 mb-md-0 text-white">
                    <h3 class="fw-bold display-6">Petualangan Seru Menanti Anda!</h3>
                    <p class="promo-text">
                        Telusuri keindahan Gunung Telomoyo bersama jip wisata kami. Rasakan sensasi melintasi jalur ekstrem, hutan hijau, dan panorama alam yang memukau.
                        Kami menawarkan paket terbaik untuk pengalaman tak terlupakan bersama keluarga maupun teman.
                    </p>

                    {{-- Include Box --}}
                    <div class="include-box mt-4 p-4 rounded-4 shadow glass-effect">
                        <h6 class="fw-bold mb-3 text-warning">Include:</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Kapasitas Jeep 4 Orang</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Pilihan Paket Wisata</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Driver Berpengalaman</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-warning me-2"></i> Area Parkir Luas & Toilet</li>
                        </ul>
                    </div>
                </div>

                {{-- Gambar Carousel --}}
                <div class="col-md-6 text-center">
                    <div id="promoCarousel" class="carousel slide promo-carousel" data-bs-ride="carousel" data-bs-interval="2500">
                        <div class="carousel-inner rounded-4 shadow">
                            <div class="carousel-item active">
                                <img src="{{ asset('asset/img/hero-telomoyo2.png') }}" class="d-block w-100 promo-image" alt="Gambar 1">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('asset/img/hero-telomoyo1.png') }}" class="d-block w-100 promo-image" alt="Gambar 2">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('asset/img/telomoyojip1.png') }}" class="d-block w-100 promo-image" alt="Gambar 3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
