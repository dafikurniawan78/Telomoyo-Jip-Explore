@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    {{-- Judul --}}
    <h1 class="mb-4">Dashboard</h1>
    <p class="text-muted">Selamat datang di Dashboard Admin Telomoyo Jip Explore!</p>

    {{-- Statistik Ringkas --}}
    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalPemesanan }}</h3>
                    <p>Total Pemesanan</p>
                </div>
                <div class="icon"><i class="fas fa-receipt"></i></div>
                <a href="{{ route('admin.pemesanan.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-12">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalPending }}</h3>
                    <p>Pemesanan Pending</p>
                </div>
                <div class="icon"><i class="fas fa-clock"></i></div>
                <a href="{{ route('admin.pemesanan.index') }}" class="small-box-footer">
                    Verifikasi <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalAntrean }}</h3>
                    <p>Antrean Aktif</p>
                </div>
                <div class="icon"><i class="fas fa-stream"></i></div>
                <a href="{{ route('admin.antrean.index') }}" class="small-box-footer">
                    Kelola Antrean <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-12">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $jipTersedia }}/{{ $totalJip }}</h3>
                    <p>Jip Tersedia</p>
                </div>
                <div class="icon"><i class="fas fa-car"></i></div>
                <a href="{{ route('admin.jip.index') }}" class="small-box-footer">
                    Lihat Data Jip <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>


    {{-- Grafik Pemesanan Bulanan --}}
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-chart-line"></i> Statistik Pemesanan Bulanan</h5>
        </div>
        <div class="card-body">
            <canvas id="pemesananChart" height="90"></canvas>
        </div>
    </div>

    {{-- Pemesanan Terbaru --}}
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0"><i class="fas fa-clock"></i> Pemesanan Terbaru</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Paket</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPemesanan as $p)
                        <tr>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->paketWisata->nama_paket ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_berangkat)->format('d-m-Y') }}</td>
                            <td>
                                <span class="badge
                                    @if($p->status == 'pending') bg-warning text-dark
                                    @elseif($p->status == 'disetujui') bg-success
                                    @else bg-danger @endif">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('pemesananChart').getContext('2d');
    const pemesananChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Jumlah Pemesanan',
                data: @json($chartData),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0,123,255,0.2)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: { responsive: true }
    });
</script>
@endpush
