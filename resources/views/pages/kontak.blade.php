@extends('layouts.app')

@section('title', 'Kontak | Telomoyo Jip Explore')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kontakstyle.css') }}">
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header text-center bg-light text-danger-emphasis py-3">
                    <h2 class="fw-bold mb-0"><i class="bi bi-envelope-fill"></i> Kontak Kami</h2>
                </div>
                <div class="card-body p-4">
                    <p class="mb-4 text-center">
                        Hubungi kami melalui form di bawah ini atau melalui kontak langsung.
                    </p>

                    <form>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan</label>
                            <textarea class="form-control" id="pesan" name="pesan" rows="5" placeholder="Pesan" disabled></textarea>
                        </div>
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-danger px-4 shadow-sm rounded-pill" disabled>
                                <i class="bi bi-send-fill"></i> Kirim Pesan
                            </button>
                            <p class="mt-2 fst-italic text-muted">* Form sementara tidak aktif.</p>
                        </div>
                    </form>

                    <hr class="my-4">
                    <div class="text-center mb-4">
                        <p><i class="bi bi-telephone-fill"></i> Telepon: <a href="tel:+6282138088118">+62 821-3808-8118</a></p>
                        <p><i class="bi bi-instagram"></i> Instagram: <a href="https://www.instagram.com/telomoyojip/" target="_blank">@telomoyojip</a></p>
                        <p><i class="bi bi-geo-alt-fill"></i> Alamat: Parkir Telomoyo via Dalangan, Pandean, Kec.Ngablak, Kab.Magelang</p>
                    </div>

                    <div class="map-responsive">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.1234567890!2d110.215678!3d-7.502345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a1234567890%3A0xabcdef1234567890!2sTelomoyo%20Jip%20Explore!5e0!3m2!1sid!2sid!4v1696181234567!5m2!1sid!2sid"
                            width="100%"
                            height="350"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
