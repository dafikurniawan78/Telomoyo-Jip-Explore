<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pemesanan.index') }}" class="nav-link {{ request()->routeIs('admin.pemesanan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>Pemesanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.paket-wisata.index') }}" class="nav-link {{ request()->routeIs('admin.paket-wisata.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p>Paket Wisata</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.lokasi-jemput.index') }}" class="nav-link {{ request()->routeIs('admin.lokasi-jemput.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-pin"></i>
                        <p>Lokasi Jemput</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.jip.index') }}" class="nav-link {{ request()->routeIs('admin.jip.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-car"></i>
                        <p>Data Jip</p>
                    </a>
                </li>
                <!-- Tambahkan menu lain di sini -->
            </ul>
        </nav>
    </div>
</aside>
