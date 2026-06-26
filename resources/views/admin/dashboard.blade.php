@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard Admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- JUDUL -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Dashboard Admin 🎓
            </h4>

            <p class="text-muted mb-0">
                Selamat Datang di sistem E-Learning Kampus
            </p>
        </div>

    </div>

    <!-- CARD STATISTIK -->
    <div class="row">

        <!-- Total Mahasiswa -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <span class="fw-semibold d-block mb-1">
                                Total Mahasiswa
                            </span>

                            <h3 class="card-title mb-2">
                                {{ $totalMahasiswa }}
                            </h3>

                            <small class="text-success fw-semibold">
                                Mahasiswa Aktif
                            </small>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-primary">

                                <i class="bx bx-group fs-4"></i>

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Total Dosen -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <span class="fw-semibold d-block mb-1">
                                Total Dosen
                            </span>

                            <h3 class="card-title mb-2">
                                {{ $totalDosen }}
                            </h3>

                            <small class="text-info fw-semibold">
                                Dosen Pengajar
                            </small>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-success">

                                <i class="bx bx-book-reader fs-4"></i>

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Mata Kuliah -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <span class="fw-semibold d-block mb-1">
                                Mata Kuliah
                            </span>

                            <h3 class="card-title mb-2">
                                {{ $totalMatkul }}
                            </h3>

                            <small class="text-warning fw-semibold">
                                Mata Kuliah Aktif
                            </small>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-warning">

                                <i class="bx bx-book fs-4"></i>

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Total Nilai -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <span class="fw-semibold d-block mb-1">
                                Total Nilai
                            </span>

                            <h3 class="card-title mb-2">
                                {{ $totalNilai }}
                            </h3>

                            <small class="text-danger fw-semibold">
                                Data Nilai Mahasiswa
                            </small>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-danger">

                                <i class="bx bx-bar-chart-alt fs-4"></i>

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- GRAFIK & AKTIVITAS -->
    <div class="row">

        <!-- Grafik -->
        <div class="col-lg-8 mb-4">

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="card-title mb-0">
                        Statistik Aktivitas Mahasiswa
                    </h5>

                </div>

                <div class="card-body">

                    <canvas id="myChart" height="120"></canvas>

                </div>

            </div>

        </div>

        <!-- Aktivitas -->
        <div class="col-lg-4 mb-4">

            <div class="card">

                <div class="card-header">

                    <h5 class="card-title mb-0">
                        Aktivitas Terbaru
                    </h5>

                </div>

                <div class="card-body">

                    <ul class="list-group">

                        <li class="list-group-item d-flex align-items-center">
                            <i class="bx bx-upload me-2 text-primary"></i>
                            Mahasiswa upload tugas
                        </li>

                        <li class="list-group-item d-flex align-items-center">
                            <i class="bx bx-book-add me-2 text-success"></i>
                            Dosen upload materi
                        </li>

                        <li class="list-group-item d-flex align-items-center">
                            <i class="bx bx-edit-alt me-2 text-warning"></i>
                            Quiz baru dibuat
                        </li>

                        <li class="list-group-item d-flex align-items-center">
                            <i class="bx bx-user-check me-2 text-info"></i>
                            Aktivitas login mahasiswa
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <!-- TABLE NILAI -->
    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h5 class="card-title mb-0">
                        Nilai Mahasiswa Terbaru
                    </h5>

                    <a href="/admin/nilai"
                       class="btn btn-sm btn-primary">

                        Lihat Semua

                    </a>

                </div>

                <div class="table-responsive text-nowrap">

                    <table class="table">

                        <thead>

                            <tr>

                                <th>Mahasiswa</th>

                                <th>Kelas</th>

                                <th>Mata Kuliah</th>

                                <th>Nilai</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($nilaiTerbaru as $nilai)

                            <tr>

                                <td>
                                    {{ $nilai->mahasiswa }}
                                </td>

                                <td>
                                    {{ $nilai->kelas }}
                                </td>

                                <td>
                                    {{ $nilai->mata_kuliah }}
                                </td>

                                <td>
                                    {{ $nilai->nilai }}
                                </td>

                                <td>

                                    @if($nilai->status == 'Lulus')

                                        <span class="badge bg-label-success">
                                            Lulus
                                        </span>

                                    @else

                                        <span class="badge bg-label-danger">
                                            Tidak Lulus
                                        </span>

                                    @endif

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="5" class="text-center">
                                    Belum ada data nilai
                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const ctx = document.getElementById('myChart');

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],

            datasets: [{

                label: 'Mahasiswa Aktif',

                data: [12, 19, 10, 25, 22],

                borderWidth: 2,

                tension: 0.4,

                fill: true

            }]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    display: true

                }

            }

        }

    });

</script>

@endsection
