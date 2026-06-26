@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard Mahasiswa')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- JUDUL -->
    <h4 class="fw-bold py-3 mb-4">
        Dashboard Mahasiswa 🎓
    </h4>

    <!-- CARD STATISTIK -->
    <div class="row">

        <!-- Total Kelas -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <span class="fw-semibold d-block mb-1">
                                Total Kelas
                            </span>

                            <h3 class="card-title mb-2">
                                {{ $totalKelas }}
                            </h3>

                            <small class="text-primary fw-semibold">
                                Kelas Aktif
                            </small>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-building-house"></i>
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Total Tugas -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <span class="fw-semibold d-block mb-1">
                                Total Tugas
                            </span>

                            <h3 class="card-title mb-2">
                                {{ $totalTugas }}
                            </h3>

                            <small class="text-warning fw-semibold">
                                Tugas Aktif
                            </small>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-task"></i>
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Deadline -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <span class="fw-semibold d-block mb-1">
                                Deadline
                            </span>

                            <h3 class="card-title mb-2">
                                {{ $deadlineMingguIni }}
                            </h3>

                            <small class="text-danger fw-semibold">
                                Deadline Minggu Ini
                            </small>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="bx bx-time"></i>
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Rata-rata Nilai -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <span class="fw-semibold d-block mb-1">
                                Rata-rata Nilai
                            </span>

                            <h3 class="card-title mb-2">
                                {{ $rataRataNilai }}
                            </h3>

                            <small class="text-success fw-semibold">
                                @if($rataRataNilai >= 85)
                                    Sangat Baik
                                @elseif($rataRataNilai >= 75)
                                    Baik
                                @elseif($rataRataNilai >= 60)
                                    Cukup
                                @else
                                    Perlu Ditingkatkan
                                @endif
                            </small>

                        </div>

                        <div class="avatar">

                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-bar-chart"></i>
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- MATERI & DEADLINE -->
    <div class="row">

        <!-- Materi Terbaru -->
        <div class="col-lg-8 mb-4">

            <div class="card">

                <div class="card-header">

                    <h5 class="card-title mb-0">
                        Materi Terbaru
                    </h5>

                </div>

                <div class="table-responsive text-nowrap">

                    <table class="table">

                        <thead>

                            <tr>
                                <th>Mata Kuliah</th>
                                <th>Materi</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($materiTerbaru as $materi)

                            <tr>

                                <td>
                                    {{ $materi->mata_kuliah ?? $materi->nama_mk ?? $materi->kelas ?? '-' }}
                                </td>

                                <td>
                                    {{ $materi->judul_materi ?? $materi->judul ?? $materi->materi ?? $materi->nama_materi ?? '-' }}
                                </td>

                                <td>

                                    @if(!empty($materi->file))
                                        <a href="{{ asset('storage/' . $materi->file) }}"
                                           class="btn btn-primary btn-sm"
                                           download>
                                            Download
                                        </a>
                                    @elseif(!empty($materi->file_materi))
                                        <a href="{{ asset('storage/' . $materi->file_materi) }}"
                                           class="btn btn-primary btn-sm"
                                           download>
                                            Download
                                        </a>
                                    @else
                                        <span class="badge bg-label-secondary">
                                            Tidak ada file
                                        </span>
                                    @endif

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="3" class="text-center">
                                    Belum ada materi terbaru.
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- Deadline Tugas -->
        <div class="col-lg-4 mb-4">

            <div class="card">

                <div class="card-header">

                    <h5 class="card-title">
                        Deadline Tugas
                    </h5>

                </div>

                <div class="card-body">

                    <ul class="list-group">

                        @forelse($deadlineTugas as $tugas)

                        <li class="list-group-item">

                            {{ $tugas->judul_tugas ?? $tugas->judul ?? $tugas->nama_tugas ?? 'Tugas' }}
                            -
                            {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y') }}

                        </li>

                        @empty

                        <li class="list-group-item text-center">
                            Tidak ada deadline tugas.
                        </li>

                        @endforelse

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <!-- NILAI TERBARU -->
    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-header">

                    <h5 class="card-title">
                        Nilai Terbaru
                    </h5>

                </div>

                <div class="table-responsive text-nowrap">

                    <table class="table">

                        <thead>

                            <tr>
                                <th>Mata Kuliah</th>
                                <th>Nilai</th>
                                <th>Grade</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($nilaiTerbaru as $nilai)

                            <tr>

                                <td>
                                    {{ $nilai->mata_kuliah ?? '-' }}
                                </td>

                                <td>
                                    {{ $nilai->nilai_akhir }}
                                </td>

                                <td>
                                    <span class="badge bg-label-primary">
                                        {{ $nilai->grade }}
                                    </span>
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
                                <td colspan="4" class="text-center">
                                    Belum ada nilai terbaru.
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
@endsection
