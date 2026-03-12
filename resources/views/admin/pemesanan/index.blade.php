@extends('layouts.admin')

@section('title', 'Kelola Pemesanan')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 fw-bold">Kelola Pemesanan</h2>

    {{-- Breadcrumb + Filter --}}
    <div class="bg-light rounded-3 shadow-sm p-3 mb-4 d-flex justify-content-between align-items-center flex-wrap">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-2 mb-md-0">
            <ol class="breadcrumb mb-0 p-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-muted fw-medium text-decoration-none">
                        <i class="fas fa-tachometer-alt me-1"></i>
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-primary fw-medium">
                        <i class="fas fa-receipt me-1"></i>
                        Pemesanan
                    </span>
                </li>
            </ol>
        </nav>

        {{-- Filter --}}
        <div>
            <select id="filterStatus" class="form-select d-inline-block" style="width: 200px;">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
    </div>

    {{-- Tombol Tambah --}}
    <div class="mb-3">
        <a href="{{ route('admin.pemesanan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Pesan
        </a>
    </div>

    {{-- Tabel Data --}}
    <div class="card shadow-lg rounded-3">
        <div class="card-body p-3">
            <div class="table-responsive rounded-3 p-2" style="overflow-x: auto; overflow-y: auto; max-height: 500px;">
                <table class="table table-striped table-bordered mb-0" style="min-width: 1600px;">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Paket Wisata</th>
                            <th>Lokasi Jemput</th>
                            <th>Tanggal</th>
                            <th>Jumlah Orang</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Diproses Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemesanans as $pemesanan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pemesanan->nama }}</td>
                                <td>{{ $pemesanan->telepon }}</td>
                                <td>{{ $pemesanan->paketWisata->nama_paket ?? '-' }}</td>
                                <td>{{ $pemesanan->lokasiJemput->nama_lokasi ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_berangkat)->format('d-m-Y') }}</td>
                                <td>{{ $pemesanan->jumlah_orang }} org</td>
                                <td>Rp {{ number_format($pemesanan->total, 0, ',', '.') }}</td>
                                <td>
                                    @if ($pemesanan->status != 'ditolak')
                                        <form action="{{ route('admin.pemesanan.updatePayment', $pemesanan->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="payment_status" class="form-select form-select-sm" style="width: 100px;" data-current="{{ $pemesanan->payment_status }}">
                                                <option value="Belum Ada" {{ $pemesanan->payment_status == 'Belum Ada' ? 'selected' : '' }}>Belum Ada</option>
                                                <option value="Unpaid" {{ $pemesanan->payment_status == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                <option value="DP" {{ $pemesanan->payment_status == 'DP' ? 'selected' : '' }}>DP</option>
                                                <option value="Cash" {{ $pemesanan->payment_status == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            </select>
                                        </form>
                                    @else
                                        <span class="badge bg-secondary">{{ $pemesanan->payment_status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($pemesanan->status == 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif ($pemesanan->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($pemesanan->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($pemesanan->bukti_pembayaran)
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#buktiModal{{ $pemesanan->id }}">
                                            <i class="fas fa-image"></i> Lihat
                                        </button>

                                        <!-- Modal Bukti Pembayaran -->
                                        <div class="modal fade" id="buktiModal{{ $pemesanan->id }}" tabindex="-1" aria-labelledby="buktiModalLabel{{ $pemesanan->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-md modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="buktiModalLabel{{ $pemesanan->id }}">Bukti Pembayaran</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/' . $pemesanan->bukti_pembayaran) }}" class="img-fluid rounded shadow" alt="Bukti Pembayaran">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $pemesanan->approvedBy->name ?? '-' }}</td>
                                <td>
                                    {{-- Tombol Setujui --}}
                                    @if ($pemesanan->status == 'pending')
                                        <form action="{{ route('admin.pemesanan.updateStatus', $pemesanan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="disetujui">
                                            <button class="btn btn-sm btn-success" {{ $pemesanan->payment_status == 'Belum Ada' ? 'disabled' : '' }}>
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>

                                        {{-- Tombol Tolak --}}
                                        <form action="{{ route('admin.pemesanan.updateStatus', $pemesanan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    @endif
                                    {{-- Detail --}}
                                    <a href="{{ route('admin.pemesanan.detail', $pemesanan->id) }}" class="btn btn-sm btn-secondary me-1">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.pemesanan.destroy', $pemesanan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pemesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted">Belum ada data pemesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $pemesanans->links() }}
    </div>
</div>
@push('scripts')
<script>
    document.getElementById('filterStatus').addEventListener('change', function() {
        const status = this.value;
        const url = new URL(window.location.href);

        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status')
        }

        window.location.href = url.toString();
    });

    document.querySelectorAll('select[name="payment_status"]').forEach(function(select) {
        select.addEventListener('change', function(e) {
            if(confirm('Yakin ingin mengubah status pembayaran?')) {
                e.target.form.submit(); // langsung submit form
            } else {
                // kalau batal, kembalikan nilai sebelumnya
                e.target.value = e.target.getAttribute('data-current');
            }
        });
    });
</script>
@endpush
@endsection
