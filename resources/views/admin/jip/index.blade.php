@extends('layouts.admin')

@section('title', 'Kelola Data Jip')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 fw-bold">Kelola Data Jip</h2>

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
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-primary fw-medium">
                        <i class="fas fa-car me-1"></i>
                        Data Jip
                    </span>
                </li>
            </ol>
        </nav>
    </div>

    {{-- Tombol Tambah --}}
    <div class="mb-3">
        <a href="{{ route('admin.jip.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Tambah Jip
        </a>
    </div>

    {{-- Tabel Data --}}
    <div class="card shadow-lg rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive rounded">
                <table class="table table-striped mb-0">
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
                                <td>
                                    @if($jip->driver)
                                        {{ $jip->driver }}
                                    @else
                                        <span class="badge bg-secondary">Belum ada driver</span>
                                    @endif
                                </td>
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
                                    <a href="{{ route('admin.jip.edit', $jip->id) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.jip.destroy', $jip->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data jip ini?')">
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

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $jips->links() }}
    </div>
</div>
@endsection
