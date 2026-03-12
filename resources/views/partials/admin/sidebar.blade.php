<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-decoration-none">
        <img src="{{ asset('../asset/img/Logo TJE.png') }}" alt="Logo TJE" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold">TJE Admin System</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Manajemen Pemesanan & Pelayanan --}}
                <li class="nav-header">Pelayanan</li>
                {{-- Pemesanan --}}
                <li class="nav-item">
                    <a href="{{ route('admin.pemesanan.index') }}" class="nav-link {{ request()->routeIs('admin.pemesanan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>Pemesanan</p>
                    </a>
                </li>

                {{-- Antrean --}}
                <li class="nav-item">
                    <a href="{{ route('admin.antrean.index') }}" class="nav-link {{ request()->routeIs('admin.antrean.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-stream"></i>
                        <p>Antrean</p>
                    </a>
                </li>

                {{-- Alokasi --}}
                <li class="nav-item">
                    <a href="{{ route('admin.alokasi.index') }}" class="nav-link {{ request()->routeIs('admin.alokasi.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Alokasi</p>
                    </a>
                </li>

                {{-- Kelola Data Master --}}
                <li class="nav-header">Kelola Data</li>
                {{-- Paket Wisata --}}
                <li class="nav-item">
                    <a href="{{ route('admin.paket-wisata.index') }}"
                    class="nav-link {{ request()->routeIs('admin.paket-wisata.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p>Paket Wisata</p>
                    </a>
                </li>

                {{-- Lokasi Jemput --}}
                <li class="nav-item">
                    <a href="{{ route('admin.lokasi-jemput.index') }}"
                    class="nav-link {{ request()->routeIs('admin.lokasi-jemput.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-pin"></i>
                        <p>Lokasi Jemput</p>
                    </a>
                </li>

                {{-- Data Jip --}}
                <li class="nav-item">
                    <a href="{{ route('admin.jip.index') }}"
                    class="nav-link {{ request()->routeIs('admin.jip.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-car"></i>
                        <p>Data Jip</p>
                    </a>
                </li>

                {{-- <li class="nav-header">Analisis</li> --}}
                {{-- Analisis FCFS --}}
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.analisis-fcfs.index') }}"
                    class="nav-link {{ request()->routeIs('admin.analisis-fcfs.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-project-diagram"></i>
                        <p>Analisis FCFS</p>
                    </a>
                </li> --}}
            </ul>
        </nav>
    </div>
</aside>
