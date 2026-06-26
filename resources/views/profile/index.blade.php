<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Dosen</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background: #f5f5f9;
        }
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: white;
            border-right: 1px solid #ddd;
            padding: 20px;
            overflow-y: auto;
        }
        .sidebar .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .sidebar .role-badge {
            font-size: 12px;
            color: #888;
            margin-bottom: 25px;
        }
        .sidebar .menu-label {
            font-size: 11px;
            font-weight: 600;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 15px 0 8px 10px;
        }
        .sidebar .menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 15px;
            color: #566a7f;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 3px;
            font-size: 14px;
            transition: all 0.2s;
        }
        .sidebar .menu a:hover,
        .sidebar .menu a.active {
            background: #ececff;
            color: #696cff;
        }
        .sidebar .menu a i {
            font-size: 18px;
        }
        .content {
            margin-left: 260px;
            padding: 25px;
        }
        .topbar {
            background: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }
        .card {
            border: none;
        }
        .logout-link {
            color: #ff4d4d !important;
        }
        .logout-link:hover {
            background: #fff0f0 !important;
            color: #cc0000 !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo text-primary">
            ⚡ E-Learning
        </div>
        <div class="role-badge">
            <i class="bi bi-person-badge"></i> Panel Dosen
        </div>

        <div class="menu">
            <div class="menu-label">Main Menu</div>

            <a href="{{ route('dosen.dashboard') }}"
               class="{{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="{{ route('dosen.kelas') }}"
               class="{{ request()->routeIs('dosen.kelas*') ? 'active' : '' }}">
                <i class="bi bi-mortarboard"></i> Kelas
            </a>

            <a href="{{ route('dosen.kelas_pengganti') }}"
               class="{{ request()->routeIs('dosen.kelas_pengganti*') ? 'active' : '' }}">
                <i class="bi bi-calendar2-check"></i> Kelas Pengganti
            </a>

            <a href="{{ route('dosen.materi') }}"
               class="{{ request()->routeIs('dosen.materi*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark"></i> Materi
            </a>

            <a href="{{ route('dosen.tugas') }}"
               class="{{ request()->routeIs('dosen.tugas*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Tugas
            </a>

            <a href="{{ route('dosen.mahasiswa') }}"
               class="{{ request()->routeIs('dosen.mahasiswa*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Mahasiswa
            </a>

            <a href="{{ route('dosen.nilai') }}"
               class="{{ request()->routeIs('dosen.nilai*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i> Nilai
            </a>

            <hr>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit"
                        class="btn p-0 w-100 text-start logout-link"
                        style="background:none;border:none;">
                    <a href="#" class="logout-link"
                       onclick="this.closest('form').submit(); return false;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </button>
            </form>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Topbar -->
        <div class="topbar d-flex justify-content-between align-items-center">
            <input type="text" class="form-control w-50" placeholder="Search...">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">{{ Auth::user()->name ?? 'Dosen' }}</span>
                <i class="bi bi-person-circle fs-3 text-primary"></i>
            </div>
        </div>

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
