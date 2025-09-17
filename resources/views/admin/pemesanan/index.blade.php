@extends('layouts.admin')

@section('title', 'Kelola Pemesanan')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <h2 class="mb-3">Kelola Pemesanan</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pemesanan</li>
        </ol>
    </nav>

    {{-- Tabel Data --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Paket Wisata</th>
                        <th>Lokasi Jemput</th>
                        <th>Tanggal</th>
                        <th>Jumlah Orang</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th style="width: 150px;">Aksi</th>
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
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
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
                            <td>
                                {{-- Tombol Setujui --}}
                                @if ($pemesanan->status == 'pending')
                                    <form action="{{ route('admin.pemesanan.updateStatus', $pemesanan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="disetujui">
                                        <button class="btn btn-sm btn-success">
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
                            <td colspan="11" class="text-center text-muted">Belum ada data pemesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $pemesanans->links() }}
    </div>
</div>
@endsection
