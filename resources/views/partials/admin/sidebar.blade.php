<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pemesanan.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>Pemesanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('paket-wisata.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p>Paket Wisata</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('lokasi-jemput.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-map-pin"></i>
                        <p>Lokasi Jemput</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jip.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-car"></i>
                        <p>Data Jip</p>
                    </a>
                </li>
                <!-- Tambahkan menu lain di sini -->
            </ul>
        </nav>
    </div>
</aside>
