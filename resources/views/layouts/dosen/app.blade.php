<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dosen.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">⚡</span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">E-Learning</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0 mx-3 mb-2"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        {{-- Dashboard --}}
        <li class="menu-item {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
            <a href="{{ route('dosen.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Akademik</span>
        </li>

        {{-- Kelas --}}
        <li class="menu-item {{ request()->routeIs('dosen.kelas*') ? 'active' : '' }}">
            <a href="{{ route('dosen.kelas') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-chalkboard"></i>
                <div>Kelas</div>
            </a>
        </li>

        {{-- Kelas Pengganti --}}
        <li class="menu-item {{ request()->routeIs('dosen.kelas_pengganti*') ? 'active' : '' }}">
            <a href="{{ route('dosen.kelas_pengganti') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-check"></i>
                <div>Kelas Pengganti</div>
            </a>
        </li>

        {{-- Materi --}}
        <li class="menu-item {{ request()->routeIs('dosen.materi*') ? 'active' : '' }}">
            <a href="{{ route('dosen.materi') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-open"></i>
                <div>Materi</div>
            </a>
        </li>

        {{-- Tugas --}}
        <li class="menu-item {{ request()->routeIs('dosen.tugas*') ? 'active' : '' }}">
            <a href="{{ route('dosen.tugas') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div>Tugas</div>
            </a>
        </li>

        {{-- Mahasiswa --}}
        <li class="menu-item {{ request()->routeIs('dosen.mahasiswa*') ? 'active' : '' }}">
            <a href="{{ route('dosen.mahasiswa') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div>Mahasiswa</div>
            </a>
        </li>

        {{-- Nilai --}}
        <li class="menu-item {{ request()->routeIs('dosen.nilai*') ? 'active' : '' }}">
            <a href="{{ route('dosen.nilai') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                <div>Nilai</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Akun</span>
        </li>

        {{-- Logout --}}
        <li class="menu-item">
            <a href="#" class="menu-link"
               onclick="event.preventDefault(); document.getElementById('logout-form-dosen').submit();">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div>Logout</div>
            </a>
            <form id="logout-form-dosen" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</aside>
