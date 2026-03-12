@extends('layouts.admin')

@section('title', 'Analisis FCFS Antrean')

@section('content')
<div class="container-fluid">

    <h2 class="mb-3 fw-bold">Analisis Urutan Antrean FCFS</h2>

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
                        <i class="fas fa-stream me-1"></i> Analisis FCFS
                    </span>
                </li>
            </ol>
        </nav>

        {{-- Filter Tanggal --}}
        <div class="d-flex flex-wrap align-items-center gap-2">
            <label for="filterTanggal" class="fw-semibold me-2 mb-0">
                <i class="fas fa-filter me-1"></i> Filter Tanggal:
            </label>

            <select id="filterTanggal" class="form-select form-select-sm" style="width: 180px;">
                <option value="">Semua</option>
                <option value="today" {{ request('tanggalFilter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="custom" {{ request('tanggalFilter') == 'custom' ? 'selected' : '' }}>Pilih Tanggal...</option>
            </select>

            <input type="date" id="customDate" class="form-control form-control-sm"
                   style="width: 180px; display: {{ request('tanggalFilter') == 'custom' ? 'block' : 'none' }};"
                   value="{{ request('customDate') }}">
        </div>
    </div>

    {{-- Tabel Analisis FCFS --}}
    <div class="card shadow-lg rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive rounded">
                <table class="table table-striped table-bordered mb-0 align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Urutan Proses</th>
                            <th>Created At</th>
                            <th>Tanggal Request</th>
                            <th>Jam Berangkat</th>
                            <th>Paket Wisata</th>
                            <th>Status Pembayaran</th>
                            <th>Jumlah Jip</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $row)
                            <tr>
                                <td class="text-center">{{ $row->urutan_proses }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->tanggal_berangkat }}</td>
                                <td>{{ $row->jam_berangkat }}</td>
                                <td>{{ $row->nama_paket }}</td>
                                <td class="text-center">{{ $row->payment_status }}</td>
                                <td class="text-center">{{ $row->jumlah_jip }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $data->links('pagination::bootstrap-5') }}
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
            url.searchParams.set('tanggalFilter', 'today');
            url.searchParams.delete('customDate');
            window.location.href = url;
        } else if (selected === 'custom') {
            customDate.style.display = 'block';
        } else {
            url.searchParams.delete('tanggalFilter');
            url.searchParams.delete('customDate');
            window.location.href = url;
        }
    });

    customDate.addEventListener('change', function() {
        const date = this.value;
        if (date) {
            const url = new URL(window.location.href);
            url.searchParams.set('tanggalFilter', 'custom');
            url.searchParams.set('customDate', date);
            window.location.href = url;
        }
    });
</script>
@endpush
