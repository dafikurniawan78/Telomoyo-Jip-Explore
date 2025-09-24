<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">  {{-- Background putih tetap, shadow untuk menarik --}}
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars fa-lg"></i>  {{-- Ikon hamburger tetap --}}
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-dark">  {{-- Ikon dashboard --}}
                <i class="fas fa-tachometer-alt me-1"></i>
                Dashboard
            </a>
        </li>
    </ul>

    <ul class="navbar-nav ms-auto">  {{-- ms-auto untuk kanan --}}
        {{-- Dropdown User Profile (Fix: Alignment sejajar dengan d-flex align-items-center) --}}
        <li class="nav-item dropdown">
            <a class="nav-link text-dark d-flex align-items-center" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">  {{-- Tambah d-flex align-items-center untuk sejajar vertikal --}}
                <i class="fas fa-user-circle fs-5 me-2"></i>  {{-- fs-5: Ukuran sedang agar match tinggi teks --}}
                <span class="d-none d-sm-inline">{{ Auth::user()->name ?? 'Admin' }}</span>  {{-- Nama user --}}
                <i class="fas fa-chevron-down ms-1"></i>  {{-- Panah, sekarang sejajar --}}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">  {{-- Dropdown tetap --}}
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-inline">
                        @csrf
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Logout
                        </a>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
