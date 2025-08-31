@extends('layouts.admin')

@section('title', 'Kelola Data Jip')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <h2 class="mb-3">Kelola Data Jip</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Jip</li>
        </ol>
    </nav>

    {{-- Tombol Tambah --}}
    <div class="mb-3">
        <a href="{{ route('jip.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Tambah Jip
        </a>
    </div>

    {{-- Tabel Data --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Plat Nomor</th>
                        <th>Kapasitas</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jips as $jip)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $jip->plat_nomor }}</td>
                            <td>{{ $jip->kapasitas }}</td>
                            <td>{{ $jip->driver ?? '-' }}</td>
                            <td>
                                @if($jip->status == 'tersedia')
                                    <span class="badge bg-success">{{ ucfirst($jip->status) }}</span>
                                @elseif($jip->status == 'digunakan')
                                    <span class="badge bg-warning text-dark">{{ ucfirst($jip->status) }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($jip->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('jip.edit', $jip->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('jip.destroy', $jip->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data jip ini?')">
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
                            <td colspan="6" class="text-center text-muted">Belum ada data jip.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
