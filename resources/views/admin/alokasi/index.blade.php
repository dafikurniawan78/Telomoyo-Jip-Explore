@extends('layouts.admin')

@section('title', 'Data Alokasi Jip')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 fw-bold">Alokasi Jip</h2>

    {{-- Breadcrumb + Filter --}}
    <div class="bg-light rounded-3 shadow-sm p-3 mb-4 d-flex flex-wrap justify-content-between align-items-center">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-0">
            <ol class="breadcrumb mb-0 p-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-muted fw-medium text-decoration-none">
                        <i class="fas fa-tachometer-alt me-1"></i>
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-primary fw-medium">
                        <i class="fas fas fa-tasks me-1"></i>
                        Alokasi
                    </span>
                </li>
            </ol>
        </nav>

        {{-- Filter --}}
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

    {{-- Tabel Data Alokasi --}}
    <div class="card shadow-lg rounded">
        <div class="card-body p-0">
            <div class="table-responsive rounded">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Wisatawan</th>
                            <th>Tanggal</th>
                            <th>Paket Wisata</th>
                            <th>Jumlah Orang</th>
                            <th>Jumlah Jip</th>
                            <th>Lokasi Penjemputan</th>
                            <th>Plat Jip Dialokasikan</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($antreans as $antrean)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $antrean->pemesanan->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($antrean->pemesanan->tanggal_berangkat)->format('d-m-Y') }}</td>
                                <td>{{ $antrean->pemesanan->paketWisata->nama_paket ?? '-' }}</td>
                                <td>{{ $antrean->pemesanan->jumlah_orang }} org</td>
                                <td>{{ $antrean->pemesanan->jumlah_jip }}</td>
                                <td>{{ $antrean->pemesanan->lokasiJemput->nama_lokasi ?? '-' }}</td>
                                <td class="text-center">
                                    <button type="button"
                                        class="btn btn-sm {{ $antrean->alokasiJip->count() > 0 ? 'btn-success' : 'btn-outline-secondary' }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalJip{{ $antrean->id }}">
                                        <i class="fas fa-car me-1"></i> Detail Jip
                                    </button>

                                    {{-- Modal Detail Jip --}}
                                    <div class="modal fade" id="modalJip{{ $antrean->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $antrean->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content border-0 shadow-lg rounded-3 overflow-hidden">

                                                {{-- Header --}}
                                                <div class="modal-header text-white" style="background: linear-gradient(90deg, #198754, #20c997);">
                                                    <h5 class="modal-title fw-semibold" id="modalLabel{{ $antrean->id }}">
                                                        <i class="fas fa-user me-2 text-warning"></i>
                                                        {{ $antrean->pemesanan->nama ?? 'Nama tidak diketahui' }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                {{-- Body --}}
                                                <div class="modal-body bg-light">
                                                    <div class="mb-3 text-center">
                                                        <h6 class="fw-bold text-success mb-1">
                                                            Paket Wisata:
                                                            <span class="text-dark">{{ $antrean->pemesanan->paketWisata->nama_paket ?? '-' }}</span>
                                                        </h6>
                                                        <small class="text-muted">
                                                            <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                                                            Lokasi Penjemputan:
                                                            <span class="fw-medium text-dark">{{ $antrean->pemesanan->lokasiJemput->nama_lokasi ?? '-' }}</span>
                                                        </small>
                                                    </div>

                                                    @if ($antrean->alokasiJip->count() > 0)
                                                        <div class="table-responsive">
                                                            <table class="table table-hover align-middle table-bordered">
                                                                <thead class="table-success">
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Plat Nomor</th>
                                                                        <th>Driver</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($antrean->alokasiJip as $index => $alokasi)
                                                                        <tr>
                                                                            <td class="text-center">{{ $index + 1 }}</td>
                                                                            <td>
                                                                                <i class="fas fa-car text-success me-2"></i>
                                                                                <strong>{{ $alokasi->jip->plat_nomor ?? '-' }}</strong>
                                                                            </td>
                                                                            <td>
                                                                                <i class="fas fa-user text-secondary me-1"></i>
                                                                                {{ $alokasi->jip->driver ?? 'Tanpa driver' }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <div class="text-center text-muted py-3">
                                                            <i class="fas fa-info-circle fa-2x mb-2 text-secondary"></i>
                                                            <p class="mb-0">Belum ada jip yang dialokasikan.</p>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Footer --}}
                                                <div class="modal-footer bg-success bg-opacity-10">
                                                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i> Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ $antrean->alokasiJip->first()?->waktu_mulai?->format('H:i d-m-Y') ?? '-' }}
                                </td>
                                <td>
                                    {{ $antrean->alokasiJip->first()?->waktu_selesai?->format('H:i d-m-Y') ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">Belum ada data alokasi jip.</td>
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
