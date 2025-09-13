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
                                    {{-- Detail --}}
                                    <a href="{{ route('admin.pemesanan.detail', $pemesanan->id) }}"
                                    class="btn btn-sm btn-info me-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.pemesanan.destroy', $pemesanan->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus pemesanan ini?')">
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
                                <td colspan="10" class="text-center text-muted">Belum ada data pemesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $pemesanans->links() }}
        </div>
    </div>
    @endsection
