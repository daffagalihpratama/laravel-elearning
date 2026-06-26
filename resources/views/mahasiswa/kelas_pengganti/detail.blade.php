@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Kelas Pengganti')

@section('content')
@php
    $namaMataKuliah = data_get($kelas, 'mataKuliah.nama_mata_kuliah')
        ?? data_get($kelas, 'mataKuliah.nama_mk')
        ?? data_get($kelas, 'mataKuliah.nama')
        ?? '-';

    $namaKelas = data_get($kelasPengganti, 'nama_kelas', '-');
    $semester = data_get($kelasPengganti, 'semester', '-');
    $dosen = data_get($kelasPengganti, 'dosen', '-');
    $hari = data_get($kelasPengganti, 'hari', '-');
    $ruangan = data_get($kelasPengganti, 'ruangan', '-');
    $alasan = data_get($kelasPengganti, 'alasan', '-');

    $jamMulai = data_get($kelasPengganti, 'jam_mulai')
        ? \Carbon\Carbon::parse(data_get($kelasPengganti, 'jam_mulai'))->format('H:i')
        : '-';

    $jamSelesai = data_get($kelasPengganti, 'jam_selesai')
        ? \Carbon\Carbon::parse(data_get($kelasPengganti, 'jam_selesai'))->format('H:i')
        : '-';

    $tanggalGanti = data_get($kelasPengganti, 'tanggal_ganti_kp')
        ? \Carbon\Carbon::parse(data_get($kelasPengganti, 'tanggal_ganti_kp'))->format('d M Y')
        : '-';

    $tanggalPengganti = data_get($kelasPengganti, 'tanggal_pengganti')
        ? \Carbon\Carbon::parse(data_get($kelasPengganti, 'tanggal_pengganti'))->format('d M Y')
        : '-';

    $pertemuan = data_get($kelasPengganti, 'pertemuan');
    $labelPertemuan = $pertemuan ? 'Pertemuan ' . $pertemuan : 'Kelas Pengganti';

    $statusAbsen = data_get($absensi, 'status');

    $materiBap = trim((string) data_get($bap, 'materi', ''));
    $metodePembelajaran = trim((string) data_get($bap, 'metode_pembelajaran', ''));
    $catatanDosen = trim((string) data_get($bap, 'catatan_dosen', ''));

    $sudahAbsen = in_array($statusAbsen, ['Hadir', 'Izin', 'Sakit'], true);
@endphp

<style>
    .kp-info-card {
        border: 0;
        border-radius: 14px;
        box-shadow: 0 0.125rem 0.5rem rgba(67, 89, 113, 0.08);
    }

    .kp-info-label {
        font-size: 13px;
        color: #697a8d;
        margin-bottom: 4px;
    }

    .kp-info-value {
        font-size: 15px;
        font-weight: 600;
        color: #566a7f;
        margin-bottom: 0;
    }

    .kp-table th,
    .kp-table td {
        vertical-align: middle;
        font-size: 14px;
    }

    .kp-table th {
        white-space: nowrap;
    }

    .kp-table td {
        word-break: break-word;
    }

    .kp-bap-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #e9ecef;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Detail Kelas Pengganti</h4>
            <small class="text-muted">
                {{ $namaMataKuliah }} | {{ $namaKelas }} | Semester {{ $semester }}
            </small>
        </div>

        <a href="{{ route('mahasiswa.kelas_pengganti') }}" class="btn btn-secondary btn-sm">
            <i class="bx bx-arrow-back me-1"></i>
            Kembali
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Informasi Ringkas --}}
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card kp-info-card h-100">
                <div class="card-body">
                    <div class="kp-info-label">Mata Kuliah</div>
                    <p class="kp-info-value">{{ $namaMataKuliah }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card kp-info-card h-100">
                <div class="card-body">
                    <div class="kp-info-label">Kelas</div>
                    <p class="kp-info-value">{{ $namaKelas }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card kp-info-card h-100">
                <div class="card-body">
                    <div class="kp-info-label">Pertemuan</div>
                    <p class="kp-info-value">{{ $labelPertemuan }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card kp-info-card h-100">
                <div class="card-body">
                    <div class="kp-info-label">Status Absensi</div>
                    @if($statusAbsen === 'Hadir')
                        <span class="badge bg-success px-3 py-2">Hadir</span>
                    @elseif($statusAbsen === 'Izin')
                        <span class="badge bg-info px-3 py-2">Izin</span>
                    @elseif($statusAbsen === 'Sakit')
                        <span class="badge bg-warning text-dark px-3 py-2">Sakit</span>
                    @elseif($statusAbsen === 'Alfa')
                        <span class="badge bg-danger px-3 py-2">Belum Absen</span>
                    @else
                        <span class="badge bg-secondary px-3 py-2">Belum Dibuka</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Jadwal --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header">
            <h5 class="mb-0">Informasi Jadwal Pengganti</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0 kp-table">
                    <tbody>
                        <tr>
                            <th style="width: 220px;">Dosen</th>
                            <td>{{ $dosen }}</td>
                        </tr>
                        <tr>
                            <th>Hari</th>
                            <td>{{ $hari }}</td>
                        </tr>
                        <tr>
                            <th>Jam</th>
                            <td>{{ $jamMulai }} - {{ $jamSelesai }}</td>
                        </tr>
                        <tr>
                            <th>Ruangan</th>
                            <td>{{ $ruangan }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Ganti KP</th>
                            <td>{{ $tanggalGanti }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengganti</th>
                            <td>{{ $tanggalPengganti }}</td>
                        </tr>
                        <tr>
                            <th>Alasan</th>
                            <td>{{ $alasan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- BAP dan Absensi --}}
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="mb-0">BAP dan Absensi</h5>
                <small class="text-muted">
                    Mahasiswa dapat absen jika BAP sudah diisi dan absensi sudah dibuka oleh dosen.
                </small>
            </div>

            @if($bap)
                <span class="badge bg-success px-3 py-2">BAP Sudah Diisi</span>
            @else
                <span class="badge bg-warning text-dark px-3 py-2">BAP Belum Diisi</span>
            @endif
        </div>

        <div class="card-body">

            {{-- BAP --}}
            <div class="kp-bap-box mb-4">
                <h6 class="fw-bold mb-3">Berita Acara Perkuliahan</h6>

                @if($bap)
                    <div class="mb-3">
                        <div class="kp-info-label">Materi</div>
                        <p class="mb-0">
                            {{ $materiBap !== '' ? $materiBap : '-' }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <div class="kp-info-label">Metode Pembelajaran</div>
                        <p class="mb-0">
                            {{ $metodePembelajaran !== '' ? $metodePembelajaran : '-' }}
                        </p>
                    </div>

                    <div>
                        <div class="kp-info-label">Catatan Dosen</div>
                        <p class="mb-0">
                            {{ $catatanDosen !== '' ? $catatanDosen : '-' }}
                        </p>
                    </div>
                @else
                    <div class="alert alert-warning mb-0">
                        <i class="bx bx-info-circle me-1"></i>
                        BAP belum diisi oleh dosen.
                    </div>
                @endif
            </div>

            {{-- Aksi Absensi --}}
            <div class="border-top pt-4">
                <h6 class="fw-bold mb-3">Aksi Absensi</h6>

                @if(!$bap)
                    <button type="button" class="btn btn-secondary" disabled>
                        <i class="bx bx-lock-alt me-1"></i>
                        BAP Belum Diisi
                    </button>

                    <small class="d-block text-muted mt-2">
                        Kamu belum dapat absen karena BAP belum diisi oleh dosen.
                    </small>

                @elseif(!$absensi)
                    <button type="button" class="btn btn-secondary" disabled>
                        <i class="bx bx-lock-alt me-1"></i>
                        Absensi Belum Dibuka
                    </button>

                    <small class="d-block text-muted mt-2">
                        Kamu belum dapat absen karena dosen belum membuka absensi.
                    </small>

                @elseif($sudahAbsen)
                    <button type="button" class="btn btn-success" disabled>
                        <i class="bx bx-check-circle me-1"></i>
                        Sudah Absen
                    </button>

                    <small class="d-block text-muted mt-2">
                        Status absensi kamu saat ini: <strong>{{ $statusAbsen }}</strong>.
                    </small>

                @else
                    <form action="{{ route('mahasiswa.kelas_pengganti.absen', $kelasPengganti->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bx bx-check-circle me-1"></i>
                            Absen Sekarang
                        </button>
                    </form>

                    <small class="d-block text-muted mt-2">
                        Klik tombol di atas untuk mencatat kehadiran pada kelas pengganti ini.
                    </small>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
