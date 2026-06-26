@php
use Illuminate\Support\Facades\Route;
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <!-- LOGO -->
    <div class="app-brand demo">
        <a href="{{ url('/admin') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                @include('_partials.macros')
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">
                E-Learning
            </span>
        </a>
        <a href="javascript:void(0);"
           class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-divider mt-0"></div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Main Menu</span>
        </li>

        <!-- DASHBOARD -->
        <li class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
            <a href="/admin" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard Admin</div>
            </a>
        </li>

        <!-- AKADEMIK -->
        <li class="menu-item
            {{
                request()->is('admin/users*') ||
                request()->is('admin/kelas-mahasiswa*') ||
                request()->is('admin/kelas*') ||
                request()->is('admin/kelas-pengganti*') ||
                request()->is('admin/matakuliah*') ||
                request()->is('admin/nilai*') ||
                request()->is('admin/periode-nilai*') ||
                request()->is('admin/tugas*')
                ? 'active open' : ''
            }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-book-content"></i>
                <div>Akademik</div>
            </a>

            <ul class="menu-sub">
                <!-- KELOLA USER -->
                <li class="menu-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <a href="/admin/users" class="menu-link">
                        <div>Manajemen User</div>
                    </a>
                </li>

                <!-- KELOLA MAHASISWA PER KELAS -->
                <li class="menu-item {{ request()->is('admin/kelas-mahasiswa*') ? 'active' : '' }}">
                    <a href="/admin/kelas-mahasiswa" class="menu-link">
                        <div>Manajemen Mahasiswa</div>
                    </a>
                </li>

                <!-- KELAS -->
                <li class="menu-item {{ request()->is('admin/kelas') ? 'active' : '' }}">
                    <a href="/admin/kelas" class="menu-link">
                        <div>Kelas</div>
                    </a>
                </li>

                <!-- KELAS PENGGANTI -->
                <li class="menu-item {{ request()->is('admin/kelas-pengganti*') ? 'active' : '' }}">
                    <a href="/admin/kelas-pengganti" class="menu-link">
                        <div>Kelas Pengganti</div>
                    </a>
                </li>

                <!-- MATA KULIAH -->
                <li class="menu-item {{ request()->is('admin/matakuliah*') ? 'active' : '' }}">
                    <a href="/admin/matakuliah" class="menu-link">
                        <div>Mata Kuliah</div>
                    </a>
                </li>

                <!-- NILAI -->
                <li class="menu-item {{ request()->is('admin/nilai*') ? 'active' : '' }}">
                    <a href="/admin/nilai" class="menu-link">
                        <div>Nilai</div>
                    </a>
                </li>

                <!-- PERIODE NILAI -->
                <li class="menu-item {{ request()->is('admin/periode-nilai*') ? 'active' : '' }}">
                    <a href="{{ route('admin.periode-nilai.index') }}" class="menu-link">
                        <div>Periode Nilai</div>
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
                  style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</aside>
