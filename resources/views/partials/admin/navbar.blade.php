<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="admin.dashboard" class="nav-link">Dashboard</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        {{-- Tombol Logout --}}
        <li class="nav-item d-none d-sm-inline-block">
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
            </form>
        </li>
    </ul>
</nav>
