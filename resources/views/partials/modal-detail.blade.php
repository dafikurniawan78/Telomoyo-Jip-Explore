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

            {{-- Tombol Footer --}}
            <div class="modal-footer bg-light border-0 rounded-bottom-4 justify-content-between px-4 py-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ route('pemesanan.form', $paket->id) }}" class="btn btn-danger rounded-pill px-4">
                    <i class="bi bi-cart-plus me-1"></i> Pesan Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
