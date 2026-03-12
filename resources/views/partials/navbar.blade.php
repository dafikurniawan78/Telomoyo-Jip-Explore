<nav class="navbar navbar-expand-lg sticky-top shadow-sm custom-navbar">
    <div class="container">
        {{-- Logo dan Judul --}}
        <a class="navbar-brand d-flex align-items-center fw-bold" href="/">
            <img src="{{ asset('asset/img/Logo TJE.png') }}" alt="Logo TJE" class="logo-tje me-2">
            <span class="brand-text">
                Telomoyo Jip <span class="d-block d-lg-inline">Explore</span>
            </span>
        </a>

        <button class="navbar-toggler" type="button" id="burgerButton" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>

        {{-- Menu Navigasi --}}
        <div class="navbar-collapse" id="navbarTelomoyo">
            <button class="close-sidebar d-lg-none" aria-label="Tutup">&times;</button>

            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item"><a class="nav-link nav-item-style" href="/">BERANDA</a></li>
                <li class="nav-item"><a class="nav-link nav-item-style" href="/paket">PAKET WISATA</a></li>
                <li class="nav-item"><a class="nav-link nav-item-style" href="/cek-antrean">STATUS LAYANAN</a></li>
                <li class="nav-item"><a class="nav-link nav-item-style" href="#tentang">TENTANG KAMI</a></li>
                <li class="nav-item"><a class="nav-link nav-item-style" href="/kontak">KONTAK</a></li>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const burger = document.getElementById("burgerButton");
        const menu = document.getElementById("navbarTelomoyo");
        const closeBtn =document.querySelector(".close-sidebar");

        burger.addEventListener("click", function() {
            burger.classList.toggle("active");
            menu.classList.toggle("show-sidebar");
        });

        closeBtn.addEventListener("click", function() {
            menu.classList.remove("show-sidebar");
            burger.classList.remove("active");
        });
    });
</script>
