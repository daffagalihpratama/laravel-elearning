<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- LOGO -->
    <div class="app-brand demo">
        <a href="/mahasiswa" class="app-brand-link">
            <span class="app-brand-logo demo">
                <i class="bx bx-book-reader bx-lg text-primary"></i>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">
                E-Learning
            </span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <!-- MENU -->
    <ul class="menu-inner py-1">

        <!-- HEADER -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Mahasiswa</span>
        </li>

        <!-- DASHBOARD -->
        <li class="menu-item {{ request()->is('mahasiswa') ? 'active' : '' }}">
            <a href="/mahasiswa" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- KELAS SAYA -->
        <li class="menu-item
            {{
                request()->is('mahasiswa/kelas*') ||
                request()->is('mahasiswa/kelas-pengganti*') ||
                request()->is('mahasiswa/materi*') ||
                request()->is('mahasiswa/tugas*')
                ? 'active open' : ''
            }}">

            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-book-content"></i>
                <div>Kelas Saya</div>
            </a>

            <ul class="menu-sub">

                <!-- JADWAL -->
<li class="menu-item {{ request()->is('mahasiswa/kelas') ? 'active' : '' }}">
    <a href="/mahasiswa/kelas" class="menu-link">
        <i class="menu-icon tf-icons bx bx-calendar"></i>
        <div>Jadwal Kuliah</div>
    </a>
</li>

<!-- KELAS PENGGANTI -->
<li class="menu-item {{ request()->is('mahasiswa/kelas-pengganti*') ? 'active' : '' }}">
    <a href="/mahasiswa/kelas-pengganti" class="menu-link">
        <i class="menu-icon tf-icons bx bx-refresh"></i>
        <div>Kelas Pengganti</div>
    </a>
</li>

                <!-- ABSENSI -->
                <li class="menu-item {{ request()->is('mahasiswa/absensi*') ? 'active' : '' }}">
                    <a href="{{ route('mahasiswa.absensi') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-calendar-check"></i>
                        <div>Absensi Saya</div>
                    </a>
                </li>

                <!-- NILAI -->
                <li class="menu-item {{ request()->is('mahasiswa/nilai*') ? 'active' : '' }}">
                    <a href="/mahasiswa/nilai" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-bar-chart-alt"></i>
                        <div>Nilai Saya</div>
                    </a>
                </li>

            </ul>

        </li>

        <!-- PROFIL -->
        <li class="menu-item {{ request()->is('mahasiswa/profil*') ? 'active' : '' }}">
            <a href="/mahasiswa/profil" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Profil</div>
            </a>
        </li>

        <!-- LOGOUT -->
        <li class="menu-item">
            <a href="{{ route('logout') }}"
               class="menu-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div>Logout</div>
            </a>

            <form id="logout-form"
                  action="{{ route('logout') }}"
                  method="POST"
                  style="display:none;">
                @csrf
            </form>
        </li>

    </ul>

</aside>
