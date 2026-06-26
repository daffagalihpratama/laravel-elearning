@extends('layouts/contentNavbarLayout')

@section('title', 'Kelas Saya')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Kelas Saya 🎓</h4>
        <small class="text-muted">
            Daftar kelas utama yang sedang kamu ikuti.
        </small>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Alert Error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @php
        $mahasiswaId = auth()->id();
    @endphp

    <div class="row">
        @forelse($kelas as $item)
            @php
                /*
                |--------------------------------------------------------------------------
                | INFORMASI MATA KULIAH
                |--------------------------------------------------------------------------
                */

                $namaMataKuliah = data_get($item, 'mataKuliah.nama_mata_kuliah')
                    ?? data_get($item, 'mataKuliah.nama_mk')
                    ?? data_get($item, 'mataKuliah.nama')
                    ?? 'Belum ada mata kuliah';

                /*
                |--------------------------------------------------------------------------
                | BAP KELAS BIASA
                |--------------------------------------------------------------------------
                | BAP kelas biasa sekarang dibaca langsung dari tabel kelas.
                | Kolom yang dipakai:
                | - bap_pertemuan
                | - bap_rangkuman
                | - bap_metode_pembelajaran
                | - bap_berita_acara
                | - bap_diisi_pada
                */

                $bapSudahAda = !empty($item->bap_diisi_pada);

                $materiBap = trim((string) data_get($item, 'bap_rangkuman', ''));

                $metodePembelajaran = trim((string) data_get($item, 'bap_metode_pembelajaran', ''));

                $catatanDosen = trim((string) data_get($item, 'bap_berita_acara', ''));

                $pertemuanBap = data_get($item, 'bap_pertemuan');

                $labelPertemuan = !empty($pertemuanBap)
                    ? 'Pertemuan ' . $pertemuanBap
                    : '-';

                /*
                |--------------------------------------------------------------------------
                | ABSENSI MAHASISWA
                |--------------------------------------------------------------------------
                | Jika status masih Alfa, mahasiswa tetap dianggap belum absen.
                | Mahasiswa dianggap sudah absen hanya jika status:
                | Hadir, Izin, atau Sakit.
                */

                $absensiHariIni = \App\Models\Absensi::where('mahasiswa_id', $mahasiswaId)
                    ->where('kelas_id', $item->id)
                    ->whereDate('tanggal', today())
                    ->first();

                $statusAbsensi = $absensiHariIni->status ?? null;

                $sudahAbsen = $absensiHariIni
                    && in_array($statusAbsensi, ['Hadir', 'Izin', 'Sakit'], true);

                /*
                |--------------------------------------------------------------------------
                | RINGKASAN BAP
                |--------------------------------------------------------------------------
                */

                $rangkumanParts = [];

                if ($metodePembelajaran !== '') {
                    $rangkumanParts[] = 'Metode: ' . $metodePembelajaran;
                }

                if ($catatanDosen !== '') {
                    $rangkumanParts[] = 'Catatan: ' . $catatanDosen;
                }

                $rangkumanFinal = !empty($rangkumanParts)
                    ? implode(' | ', $rangkumanParts)
                    : '-';

                $beritaAcaraFinal = $materiBap !== ''
                    ? $materiBap
                    : 'Belum ada berita acara';

                /*
                |--------------------------------------------------------------------------
                | FORMAT JAM
                |--------------------------------------------------------------------------
                */

                $jamMulai = $item->jam_mulai
                    ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i')
                    : '-';

                $jamSelesai = $item->jam_selesai
                    ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i')
                    : '-';

                /*
                |--------------------------------------------------------------------------
                | LABEL STATUS ABSENSI
                |--------------------------------------------------------------------------
                */

                $labelStatusAbsensi = 'Absen Tutup';
                $badgeStatusAbsensi = 'bg-secondary';

                if ($sudahAbsen) {
                    $labelStatusAbsensi = $statusAbsensi ?? 'Sudah Absen';
                    $badgeStatusAbsensi = 'bg-success';
                } elseif ($item->is_absen_open && !$sudahAbsen) {
                    $labelStatusAbsensi = 'Belum Absen';
                    $badgeStatusAbsensi = 'bg-danger';
                } elseif (!$item->is_absen_open && $statusAbsensi === 'Alfa') {
                    $labelStatusAbsensi = 'Belum Absen';
                    $badgeStatusAbsensi = 'bg-danger';
                }

                /*
                |--------------------------------------------------------------------------
                | LABEL STATUS BAP
                |--------------------------------------------------------------------------
                */

                $labelStatusBap = $bapSudahAda ? 'Sudah Diisi' : 'Belum Diisi';
                $badgeStatusBap = $bapSudahAda ? 'bg-success' : 'bg-warning text-dark';
            @endphp

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-3">

                    {{-- Card Header --}}
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <h5 class="mb-1 text-white fw-bold">
                                    {{ $namaMataKuliah }}
                                </h5>
                                <small class="text-white opacity-75">
                                    {{ $item->nama_kelas ?? '-' }} | Semester {{ $item->semester ?? '-' }}
                                </small>
                            </div>

                            <div class="text-end">
                                @if($item->is_absen_open)
                                    <span class="badge bg-success">
                                        <i class="bx bx-radio-circle-marked bx-flashing me-1"></i>
                                        Absen Buka
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bx bx-lock me-1"></i>
                                        Tutup
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body d-flex flex-column">

                        {{-- Informasi Kelas --}}
                        <div class="mb-3">
                            <p class="mb-2">
                                📘 <strong>Mata Kuliah:</strong> {{ $namaMataKuliah }}
                            </p>

                            <p class="mb-2">
                                🏷️ <strong>Kelas:</strong> {{ $item->nama_kelas ?? '-' }}
                            </p>

                            <p class="mb-2">
                                👨‍🏫 <strong>Dosen:</strong> {{ $item->dosen ?? '-' }}
                            </p>

                            <p class="mb-2">
                                📅 <strong>Hari:</strong> {{ $item->hari ?? '-' }}
                            </p>

                            <p class="mb-2">
                                🕐 <strong>Jam:</strong> {{ $jamMulai }} - {{ $jamSelesai }}
                            </p>

                            <p class="mb-0">
                                🏫 <strong>Ruangan:</strong> {{ $item->ruangan ?? '-' }}
                            </p>
                        </div>

                        {{-- Status --}}
                        <div class="mb-3 border-top pt-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold">Status Absensi</span>
                                <span class="badge {{ $badgeStatusAbsensi }}">
                                    {{ $labelStatusAbsensi }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Status BAP</span>
                                <span class="badge {{ $badgeStatusBap }}">
                                    {{ $labelStatusBap }}
                                </span>
                            </div>
                        </div>

                        {{-- Ringkasan BAP --}}
                        <div class="mb-3 border-top pt-3">
                            <div class="mb-2">
                                <small class="text-muted d-block fw-semibold">Pertemuan</small>
                                <div class="fw-semibold text-dark">
                                    {{ $labelPertemuan }}
                                </div>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted d-block fw-semibold">Rangkuman</small>
                                <div class="text-dark" style="white-space: normal; line-height: 1.5;">
                                    {{ \Illuminate\Support\Str::limit($rangkumanFinal, 110) }}
                                </div>
                            </div>

                            <div class="mb-0">
                                <small class="text-muted d-block fw-semibold">Berita Acara</small>
                                <div class="text-dark" style="white-space: normal; line-height: 1.5;">
                                    {{ \Illuminate\Support\Str::limit($beritaAcaraFinal, 120) }}
                                </div>
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="mt-auto">
                            <a href="{{ route('mahasiswa.kelas.detail', $item->id) }}"
                               class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center py-2">
                                <i class="bx bx-log-in-circle me-2"></i>
                                Masuk Kelas
                            </a>

                            @if($item->is_absen_open && !$sudahAbsen && $bapSudahAda)
                                <small class="d-block text-center mt-2 text-muted">
                                    Kamu belum absen. Masuk kelas untuk melakukan absensi.
                                </small>
                            @elseif($item->is_absen_open && !$bapSudahAda)
                                <small class="d-block text-center mt-2 text-muted">
                                    Absensi terbuka, tetapi BAP belum diisi oleh dosen.
                                </small>
                            @elseif($sudahAbsen)
                                <small class="d-block text-center mt-2 text-muted">
                                    Kamu sudah absen. Masuk kelas untuk melihat detail BAP.
                                </small>
                            @else
                                <small class="d-block text-center mt-2 text-muted">
                                    Masuk kelas untuk melihat detail, BAP, materi, dan tugas.
                                </small>
                            @endif

                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('mahasiswa.materi') }}" class="btn btn-outline-primary btn-sm w-50">
                                    <i class="bx bx-book me-1"></i>
                                    Materi
                                </a>

                                <a href="{{ route('mahasiswa.tugas') }}" class="btn btn-outline-warning btn-sm w-50">
                                    <i class="bx bx-task me-1"></i>
                                    Tugas
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    <i class="bx bx-info-circle me-1"></i>
                    Belum ada kelas yang tersedia.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
