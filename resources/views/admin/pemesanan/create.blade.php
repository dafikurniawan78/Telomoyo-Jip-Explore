@extends('layouts.admin')

@section('title', 'Tambah Pemesanan')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 fw-bold">Tambah Pemesanan Baru</h2>

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
                    <a href="{{ route('admin.pemesanan.index') }}" class="text-muted fw-medium text-decoration-none">
                        <i class="fas fa-clipboard-list me-1"></i>
                        Pemesanan
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
            {{-- Error Validasi --}}
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

            <form action="{{ route('admin.pemesanan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Pemesan --}}
                <div class="mb-3">
                    <label for="nama" class="form-label fw-semibold">Nama Pemesan</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama') }}" placeholder="Masukkan nama pemesan" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div class="mb-3">
                    <label for="telepon" class="form-label fw-semibold">Nomor Telepon (Opsional)</label>
                    <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror"
                        value="{{ old('telepon') }}" placeholder="Boleh dikosongkan jika tidak ada">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Paket Wisata --}}
                <div class="mb-3">
                    <label for="paket_id" class="form-label fw-semibold">Paket Wisata</label>
                    <select name="paket_id" id="paket_id" class="form-select @error('paket_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Paket Wisata --</option>
                        @foreach ($pakets as $paket)
                            <option value="{{ $paket->id }}"
                                data-harga="{{ $paket->harga }}"
                                {{ old('paket_id') == $paket->id ? 'selected' : '' }}>
                                {{ $paket->nama_paket }} - Rp{{ number_format($paket->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('paket_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Lokasi Jemput --}}
                <div class="mb-3">
                    <label for="lokasi_jemput_id" class="form-label fw-semibold">Lokasi Jemput</label>
                    <select name="lokasi_jemput_id" id="lokasi_jemput_id" class="form-select @error('lokasi_jemput_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Lokasi Jemput --</option>
                        @foreach ($lokasi_jemputs as $lokasi)
                            <option value="{{ $lokasi->id }}"
                                {{ old('lokasi_jemput_id') == $lokasi->id ? 'selected' : '' }}>
                                {{ $lokasi->nama_lokasi }}
                            </option>
                        @endforeach
                    </select>
                    @error('lokasi_jemput_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal & Jam Berangkat --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_berangkat" class="form-label fw-semibold">Tanggal Berangkat</label>
                        <input type="date" name="tanggal_berangkat" id="tanggal_berangkat"
                            class="form-control @error('tanggal_berangkat') is-invalid @enderror"
                            value="{{ old('tanggal_berangkat') }}" required>
                        @error('tanggal_berangkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jam_berangkat" class="form-label fw-semibold">Jam Berangkat</label>
                        <input type="time" name="jam_berangkat" id="jam_berangkat"
                            class="form-control @error('jam_berangkat') is-invalid @enderror"
                            value="{{ old('jam_berangkat') }}" required>
                        @error('jam_berangkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Jumlah Orang --}}
                <div class="mb-3">
                    <label for="jumlah_orang" class="form-label fw-semibold">Jumlah Orang</label>
                    <input type="number" name="jumlah_orang" id="jumlah_orang" class="form-control @error('jumlah_orang') is-invalid @enderror"
                           value="{{ old('jumlah_orang', 1) }}" min="1" required>
                    @error('jumlah_orang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Total Harga --}}
                <div class="mb-3">
                    <label for="total_display" class="form-label fw-semibold">Total Pembayaran</label>
                    <input type="text" id="total_display" class="form-control" placeholder="Otomatis dihitung" readonly>
                    <input type="hidden" name="total" id="total">
                    <small id="infoTotal" class="text-muted"></small>
                </div>

                {{-- Status Pembayaran --}}
                <div class="mb-3">
                    <label for="payment_status" class="form-label fw-semibold">Status Pembayaran</label>
                    <select name="payment_status" id="payment_status"
                        class="form-select @error('payment_status') is-invalid @enderror" required>
                        <option value="">-- Pilih Status Pembayaran --</option>
                        <option value="Unpaid" {{ old('payment_status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="DP" {{ old('payment_status') == 'DP' ? 'selected' : '' }}>DP</option>
                        <option value="Cash" {{ old('payment_status') == 'Cash' ? 'selected' : '' }}>Cash</option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Bukti Pembayaran --}}
                <div class="mb-3">
                    <label for="bukti_pembayaran" class="form-label fw-semibold">Bukti Pembayaran (Opsional)</label>
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                           class="form-control @error('bukti_pembayaran') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                    @error('bukti_pembayaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="text-end mt-4">
                    <a href="{{ route('admin.pemesanan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-1"></i> Simpan Pemesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Hitung Total Otomatis --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const paketSelect = document.getElementById('paket_id');
    const jumlahInput = document.getElementById('jumlah_orang');
    const totalDisplay = document.getElementById('total_display');
    const totalHidden = document.getElementById('total');
    const infoTotal = document.getElementById('infoTotal');

    function hitungTotal() {
        const harga = parseFloat(paketSelect.selectedOptions[0]?.getAttribute('data-harga') || 0);
        const jumlahOrang = parseInt(jumlahInput.value) || 0;
        const jumlahJip = Math.ceil(jumlahOrang / 4);
        const total = harga * jumlahJip;

        // tampilkan format Rp
        totalDisplay.value = total ? `Rp${total.toLocaleString('id-ID')}` : '';
        infoTotal.textContent = total
            ? `(${jumlahJip} jip × Rp${harga.toLocaleString('id-ID')})`
            : '';

        // nilai mentah untuk dikirim ke server
        totalHidden.value = total ? total : '';
    }

    paketSelect.addEventListener('change', hitungTotal);
    jumlahInput.addEventListener('input', hitungTotal);

    hitungTotal();
});
</script>
@endsection
