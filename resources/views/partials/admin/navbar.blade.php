<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars fa-lg"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-dark">
                <i class="fas fa-tachometer-alt me-1"></i>
                Dashboard
            </a>
        </li>
    </ul>

    <ul class="navbar-nav ms-auto">
        {{-- Dropdown User Profile --}}
        <li class="nav-item dropdown">
            <a class="nav-link text-dark d-flex align-items-center" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                <i class="fas fa-user-circle fs-5 me-2"></i>
                <span class="d-none d-sm-inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                <i class="fas fa-chevron-down ms-1"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
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
                <li>
                    <a href="{{ route('admin.register') }}" class="dropdown-item">
                        <i class="fas fa-user-plus me-2"></i> Tambah Admin/Petugas
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
