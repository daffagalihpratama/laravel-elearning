<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- LOGO -->
    <div class="app-brand demo">
        <a href="/dosen" class="app-brand-link">
            <span class="app-brand-text fw-bold ms-2">E-Learning</span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <!-- HEADER -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Dosen</span>
        </li>

        <!-- DASHBOARD -->
        <li class="menu-item {{ request()->url() == url('/dosen') ? 'active' : '' }}">
            <a href="/dosen" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- MENU DOSEN -->
        <li class="menu-item {{
            request()->url() == url('/dosen/kelas') ||
            request()->is('dosen/kelas-pengganti*') ||
            request()->is('dosen/materi*') ||
            request()->is('dosen/tugas*') ||
            request()->is('dosen/mahasiswa*') ||
            request()->is('dosen/nilai*')
            ? 'active open' : ''
        }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <div>Menu Dosen</div>
            </a>

            <ul class="menu-sub">

                <!-- KELAS -->
                <li class="menu-item {{ request()->url() == url('/dosen/kelas') ? 'active' : '' }}">
                    <a href="/dosen/kelas" class="menu-link">
                        <div>Kelas</div>
                    </a>
                </li>

                <!-- KELAS PENGGANTI -->
                <li class="menu-item {{ request()->is('dosen/kelas-pengganti*') ? 'active' : '' }}">
                    <a href="/dosen/kelas-pengganti" class="menu-link">
                        <div>Kelas Pengganti</div>
                    </a>
                </li>

                <!-- MATERI -->
                <li class="menu-item {{ request()->is('dosen/materi*') ? 'active' : '' }}">
                    <a href="/dosen/materi" class="menu-link">
                        <div>Materi</div>
                    </a>
                </li>

                <!-- TUGAS -->
                <li class="menu-item {{ request()->is('dosen/tugas*') ? 'active' : '' }}">
                    <a href="/dosen/tugas" class="menu-link">
                        <div>Tugas</div>
                    </a>
                </li>

                <!-- MAHASISWA -->
                <li class="menu-item {{ request()->is('dosen/mahasiswa*') ? 'active' : '' }}">
                    <a href="/dosen/mahasiswa" class="menu-link">
                        <div>Mahasiswa</div>
                    </a>
                </li>

                <!-- NILAI -->
                <li class="menu-item {{ request()->is('dosen/nilai*') ? 'active' : '' }}">
                    <a href="/dosen/nilai" class="menu-link">
                        <div>Nilai</div>
                    </a>
                </li>

            </ul>
        </li>

        <!-- LOGOUT -->
        <li class="menu-item">
            <a href="{{ route('logout') }}" class="menu-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div>Logout</div>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </li>

    </ul>
</aside>
