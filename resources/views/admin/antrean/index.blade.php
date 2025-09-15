@extends('layouts.admin')

@section('title', 'Kelola Antrean')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <h2 class="mb-3">Kelola Antrean</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Antrean</li>
        </ol>
    </nav>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabel Antrean --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nomor Antrean</th>
                        <th>Nama Pemesan</th>
                        <th>Paket Wisata</th>
                        <th>Status</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($antreans as $antrean)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="fw-bold">{{ $antrean->nomor_antrean }}</span></td>
                            <td>{{ $antrean->pemesanan->nama ?? '-' }}</td>
                            <td>{{ $antrean->pemesanan->paketWisata->nama_paket ?? '-' }}</td>
                            <td>
                                @if($antrean->status == 'menunggu')
                                    <span class="badge bg-secondary">Menunggu</span>
                                @elseif($antrean->status == 'sedang dilayani')
                                    <span class="badge bg-warning text-dark">Sedang Dilayani</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td>{{ $antrean->waktu_mulai ? $antrean->waktu_mulai->format('H:i d-m-Y') : '-' }}</td>
                            <td>{{ $antrean->waktu_selesai ? $antrean->waktu_selesai->format('H:i d-m-Y') : '-' }}</td>
                            <td>
                                {{-- Form Update Status --}}
                                <form action="{{ route('admin.antrean.updateStatus', $antrean->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select form-select-sm d-inline w-auto">
                                        <option value="menunggu" {{ $antrean->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="sedang dilayani" {{ $antrean->status == 'sedang dilayani' ? 'selected' : '' }}>Sedang Dilayani</option>
                                        <option value="selesai" {{ $antrean->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.antrean.destroy', $antrean->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus antrean ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada antrean.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
