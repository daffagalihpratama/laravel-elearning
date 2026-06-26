@extends('layouts/contentNavbarLayout')

@section('title', 'Detail Kelas')

@section('content')
@php
    $namaMataKuliah = data_get($kelas, 'mataKuliah.nama_mata_kuliah')
        ?? data_get($kelas, 'mataKuliah.nama_mk')
        ?? data_get($kelas, 'mataKuliah.nama')
        ?? 'Belum ada mata kuliah';

    $kodeMataKuliah = data_get($kelas, 'mataKuliah.kode')
        ?? data_get($kelas, 'mataKuliah.kode_mk')
        ?? '-';

    $namaKelas = data_get($kelas, 'nama_kelas', '-');
    $semester = data_get($kelas, 'semester', '-');
    $dosen = data_get($kelas, 'dosen', '-');
    $hari = data_get($kelas, 'hari', '-');
    $ruangan = data_get($kelas, 'ruangan', '-');

    $jamMulai = data_get($kelas, 'jam_mulai')
        ? \Carbon\Carbon::parse(data_get($kelas, 'jam_mulai'))->format('H:i')
        : '-';

    $jamSelesai = data_get($kelas, 'jam_selesai')
        ? \Carbon\Carbon::parse(data_get($kelas, 'jam_selesai'))->format('H:i')
        : '-';

    /*
    |--------------------------------------------------------------------------
    | BAP KELAS BIASA
    |--------------------------------------------------------------------------
    | BAP sekarang dibaca langsung dari tabel kelas.
    | Kolom yang dipakai:
    | bap_pertemuan
    | bap_rangkuman
    | bap_metode_pembelajaran
    | bap_berita_acara
    | bap_diisi_pada
    */

    $bapSudahAda = !empty($kelas->bap_diisi_pada);

    $materiBap = trim((string) data_get($kelas, 'bap_rangkuman', ''));

    $metodePembelajaran = trim((string) data_get($kelas, 'bap_metode_pembelajaran', ''));

    $catatanDosen = trim((string) data_get($kelas, 'bap_berita_acara', ''));

    $pertemuanBap = data_get($kelas, 'bap_pertemuan');

    $labelPertemuan = !empty($pertemuanBap)
        ? 'Pertemuan ' . $pertemuanBap
        : '-';

    $tanggalBap = !empty($kelas->bap_diisi_pada)
        ? \Carbon\Carbon::parse($kelas->bap_diisi_pada)->format('d M Y')
        : '-';

    /*
    |--------------------------------------------------------------------------
    | ABSENSI MAHASISWA
    |--------------------------------------------------------------------------
    | Jika status masih Alfa, mahasiswa tetap boleh melakukan absen.
    | Mahasiswa dianggap sudah absen hanya jika status:
    | Hadir, Izin, atau Sakit.
    */

    $absensi = null;

    if (isset($absensiMahasiswa)) {
        $absensi = $absensiMahasiswa;
    } elseif (isset($kelas->absensiMahasiswa)) {
        $absensi = $kelas->absensiMahasiswa->first();
    }

    $statusAbsen = data_get($absensi, 'status');

    $sudahAbsen = $absensi
        && in_array($statusAbsen, ['Hadir', 'Izin', 'Sakit'], true);

    $absensiDibuka = false;

    if (isset($kelas->is_absen_open)) {
        $absensiDibuka = (bool) $kelas->is_absen_open;
    } elseif (isset($kelas->absensi_dibuka)) {
        $absensiDibuka = (bool) $kelas->absensi_dibuka;
    }
@endphp

<style>
    .kelas-info-card {
        border: 0;
        border-radius: 14px;
        box-shadow: 0 0.125rem 0.5rem rgba(67, 89, 113, 0.08);
    }

    .kelas-info-label {
        font-size: 13px;
        color: #697a8d;
        margin-bottom: 4px;
    }

    .kelas-info-value {
        font-size: 15px;
        font-weight: 600;
        color: #566a7f;
        margin-bottom: 0;
    }

    .kelas-table th,
    .kelas-table td {
        vertical-align: middle;
        font-size: 14px;
    }

    .kelas-table th {
        width: 220px;
        white-space: nowrap;
    }

    .kelas-bap-box {
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
            <h4 class="fw-bold mb-1">Detail Kelas</h4>
            <small class="text-muted">
                {{ $kodeMataKuliah }} | {{ $namaMataKuliah }} | {{ $namaKelas }}
            </small>
        </div>

        <a href="{{ route('mahasiswa.kelas') }}" class="btn btn-secondary btn-sm">
            <i class="bx bx-arrow-back me-1"></i>
            Kembali
        </a>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Alert Error --}}
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
            <div class="card kelas-info-card h-100">
                <div class="card-body">
                    <div class="kelas-info-label">Mata Kuliah</div>
                    <p class="kelas-info-value">{{ $namaMataKuliah }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card kelas-info-card h-100">
                <div class="card-body">
                    <div class="kelas-info-label">Kelas</div>
                    <p class="kelas-info-value">{{ $namaKelas }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card kelas-info-card h-100">
                <div class="card-body">
                    <div class="kelas-info-label">Pertemuan</div>
                    <p class="kelas-info-value">{{ $labelPertemuan }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card kelas-info-card h-100">
                <div class="card-body">
                    <div class="kelas-info-label">Status Absensi</div>

                    @if($sudahAbsen)
                        <span class="badge bg-success px-3 py-2">
                            {{ $statusAbsen ?? 'Hadir' }}
                        </span>
                    @elseif($absensiDibuka)
                        <span class="badge bg-danger px-3 py-2">
                            Belum Absen
                        </span>
                    @else
                        <span class="badge bg-secondary px-3 py-2">
                            Absensi Tutup
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Informasi Jadwal --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header">
            <h5 class="mb-0">Informasi Jadwal Kelas</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0 kelas-table">
                    <tbody>
                        <tr>
                            <th>Kode Mata Kuliah</th>
                            <td>{{ $kodeMataKuliah }}</td>
                        </tr>
                        <tr>
                            <th>Mata Kuliah</th>
                            <td>{{ $namaMataKuliah }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $namaKelas }}</td>
                        </tr>
                        <tr>
                            <th>Semester</th>
                            <td>{{ $semester }}</td>
                        </tr>
                        <tr>
                            <th>Dosen</th>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- BAP dan Absensi --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="mb-0">BAP dan Absensi</h5>
                <small class="text-muted">
                    Mahasiswa dapat absen jika BAP sudah diisi dan absensi sedang dibuka oleh dosen.
                </small>
            </div>

            @if($bapSudahAda)
                <span class="badge bg-success px-3 py-2">BAP Sudah Diisi</span>
            @else
                <span class="badge bg-warning text-dark px-3 py-2">BAP Belum Diisi</span>
            @endif
        </div>

        <div class="card-body">

            {{-- BAP --}}
            <div class="kelas-bap-box mb-4">
                <h6 class="fw-bold mb-3">Berita Acara Perkuliahan</h6>

                @if($bapSudahAda)
                    <div class="mb-3">
                        <div class="kelas-info-label">Tanggal</div>
                        <p class="mb-0">{{ $tanggalBap }}</p>
                    </div>

                    <div class="mb-3">
                        <div class="kelas-info-label">Pertemuan</div>
                        <p class="mb-0">{{ $labelPertemuan }}</p>
                    </div>

                    <div class="mb-3">
                        <div class="kelas-info-label">Materi</div>
                        <p class="mb-0">
                            {{ $materiBap !== '' ? $materiBap : '-' }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <div class="kelas-info-label">Metode Pembelajaran</div>
                        <p class="mb-0">
                            {{ $metodePembelajaran !== '' ? $metodePembelajaran : '-' }}
                        </p>
                    </div>

                    <div>
                        <div class="kelas-info-label">Catatan Dosen</div>
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

                @if($sudahAbsen)
                    <button type="button" class="btn btn-success" disabled>
                        <i class="bx bx-check-circle me-1"></i>
                        Sudah Absen
                    </button>

                    <small class="d-block text-muted mt-2">
                        Status absensi kamu saat ini:
                        <strong>{{ $statusAbsen ?? 'Hadir' }}</strong>.
                    </small>

                @elseif(!$bapSudahAda)
                    <button type="button" class="btn btn-secondary" disabled>
                        <i class="bx bx-file-blank me-1"></i>
                        BAP Belum Ada
                    </button>

                    <small class="d-block text-muted mt-2">
                        Kamu belum dapat absen karena BAP belum diisi oleh dosen.
                    </small>

                @elseif(!$absensiDibuka)
                    <button type="button" class="btn btn-secondary" disabled>
                        <i class="bx bx-lock-alt me-1"></i>
                        Absensi Belum Dibuka
                    </button>

                    <small class="d-block text-muted mt-2">
                        Absensi hanya dapat dilakukan saat dosen membuka kelas.
                    </small>

                @else
                    <form action="{{ route('absensi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">

                        <button type="submit" class="btn btn-success">
                            <i class="bx bx-check-circle me-1"></i>
                            Absen Sekarang
                        </button>
                    </form>

                    <small class="d-block text-muted mt-2">
                        Klik tombol di atas untuk mencatat kehadiran pada kelas ini.
                    </small>
                @endif
            </div>
        </div>
    </div>

    {{-- Materi dan Tugas --}}
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">Aktivitas Kelas</h5>
        </div>

        <div class="card-body">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('mahasiswa.materi') }}" class="btn btn-outline-primary">
                    <i class="bx bx-book me-1"></i>
                    Lihat Materi
                </a>

                <a href="{{ route('mahasiswa.tugas') }}" class="btn btn-outline-warning">
                    <i class="bx bx-task me-1"></i>
                    Lihat Tugas
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
