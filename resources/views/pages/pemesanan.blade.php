@extends('layouts.app')

@section('title', 'Formulir Pemesanan | Telomoyo Jip Explore')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pemesananstyle.css') }}">
@endpush

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-5 text-danger-emphasis">Formulir Pemesanan</h2>

    <div class="card form-card">
        <div class="card-body p-4 p-md-5">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pemesanan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    {{-- Kolom Kiri --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control rounded-3" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control rounded-3" name="telepon" id="telepon" pattern="[0-9]{10,15}" maxlength="15" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Berangkat</label>
                            <input type="date" class="form-control rounded-3" name="tanggal_berangkat" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Orang</label>
                            <input type="number" class="form-control rounded-3" name="jumlah_orang" id="jumlah_orang" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Jip</label>
                            <input type="number" class="form-control rounded-3" name="jumlah_jip" id="jumlah_jip" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi Jemput</label>
                            <select class="form-select rounded-3" name="lokasi_jemput_id" required>
                                @foreach ($lokasi_jemputs as $lokasi)
                                    <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Paket Wisata</label>
                            <input type="text" class="form-control rounded-3" name="paket" value="{{ $paket->nama_paket }}" readonly>
                            <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jam Berangkat</label>
                            <div class="input-group clockpicker">
                                <input type="time" class="form-control rounded-3" id="jam_berangkat" name="jam_berangkat" placeholder="Pilih jam">
                                <span class="input-group-text"><i class="bi bi-clock"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Pembayaran</label>
                            <input type="text" class="form-control rounded-3" id="total_format" readonly>
                            <input type="hidden" name="total" id="total">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bukti Pembayaran</label>
                            <input type="file" class="form-control rounded-3" name="bukti_pembayaran" accept="image/*" required>
                            <small class="text-muted d-block mt-2">
                                Silakan lakukan pembayaran via transfer ke nomor rekening:<br>
                                <strong>a/n Mul Budi Santoso</strong><br>
                                <strong> Mandiri - 185 000 909 9000 </strong><br>
                                <strong> BCA - 1220 971 151 </strong><br>
                                lalu upload bukti transfer di sini.
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Tombol Submit --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-danger btn-form shadow">
                        Submit
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-form shadow">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        const jumlahOrangInput = $('#jumlah_orang');
        const jumlahJipInput = $('#jumlah_jip');
        const totalFormatInput = $('#total_format');
        const totalHiddenInput = $('#total');
        const hargaPaket = {{ $paket->harga }};

        // Format Rupiah
        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Hitung jumlah jip dan total
        function hitungJumlahJip() {
            const jumlahOrang = parseInt(jumlahOrangInput.val()) || 0;
            if (jumlahOrang > 0) {
                const jumlahJip = Math.ceil(jumlahOrang / 4);
                jumlahJipInput.val(jumlahJip);

                const totalAsli = jumlahJip * hargaPaket;
                totalFormatInput.val(formatRupiah(totalAsli));
                totalHiddenInput.val(totalAsli);
            } else {
                jumlahJipInput.val(0);
                totalFormatInput.val(formatRupiah(0));
                totalHiddenInput.val(0);
            }
        }

        // Reset awal
        jumlahJipInput.val(0);
        totalFormatInput.val(formatRupiah(0));
        totalHiddenInput.val(0);

        jumlahOrangInput.on('input', hitungJumlahJip);

        // Validasi input telepon
        $('#telepon').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '')
        });

        // Inisialisasi clockpicker
        $('.clockpicker').clockpicker({
            autoclose: true,
            placement: 'bottom',
            align: 'left',
            appendTo: 'body'
        });
    });
</script>
@endpush
@endsection
