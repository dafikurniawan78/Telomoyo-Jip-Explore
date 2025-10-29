@extends('layouts.admin')

@section('title', 'Kelola Antrean')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 fw-bold">Kelola Antrean</h2>

    {{-- Breadcrumb + Filter --}}
    <div class="bg-light rounded-3 shadow-sm p-3 mb-4 d-flex flex-wrap justify-content-between align-items-center">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-0">
            <ol class="breadcrumb mb-0 p-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-muted fw-medium text-decoration-none">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-primary fw-medium">
                        <i class="fas fa-stream me-1"></i> Antrean
                    </span>
                </li>
            </ol>
        </nav>

        {{-- Filter Dropdown di Kanan --}}
        <div class="d-flex flex-wrap align-items-center gap-2">
            <label for="filterTanggal" class="fw-semibold me-2 mb-0">
                <i class="fas fa-filter me-1"></i> Filter Tanggal:
            </label>

            <select id="filterTanggal" class="form-select form-select-sm" style="width: 180px;">
                <option value="">Semua</option>
                <option value="today" {{ request('tanggal') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="custom" {{ request('tanggal') == 'custom' ? 'selected' : '' }}>Pilih Tanggal...</option>
            </select>

            <input type="date" id="customDate" class="form-control form-control-sm"
                   style="width: 180px; display: {{ request('tanggal') == 'custom' ? 'block' : 'none' }};"
                   value="{{ request('custom_date') }}">
        </div>
    </div>

    {{-- Tabel Antrean --}}
    <div class="card shadow-lg rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive rounded">
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada antrean.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $antreans->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    const filterTanggal = document.getElementById('filterTanggal');
    const customDate = document.getElementById('customDate');

    filterTanggal.addEventListener('change', function() {
        const selected = this.value;
        const url = new URL(window.location.href);

        if (selected === 'today') {
            url.searchParams.set('tanggal', 'today');
            url.searchParams.delete('custom_date');
            window.location.href = url;
        } else if (selected === 'custom') {
            customDate.style.display = 'block';
        } else {
            url.searchParams.delete('tanggal');
            url.searchParams.delete('custom_date');
            window.location.href = url;
        }
    });

    customDate.addEventListener('change', function() {
        const date = this.value;
        if (date) {
            const url = new URL(window.location.href);
            url.searchParams.set('tanggal', 'custom');
            url.searchParams.set('custom_date', date);
            window.location.href = url;
        }
    });
</script>
@endpush
