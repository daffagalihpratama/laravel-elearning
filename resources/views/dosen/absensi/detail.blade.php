@extends('layouts.contentNavbarLayout')

@section('title', 'Detail Absensi Kelas')

@section('page-style')
<style>
    .page-title {
        font-weight: 700;
        color: #2b2c40;
    }

    .info-card {
        background: #f8f9fa;
        border-radius: 12px;
    }

    .info-label {
        font-weight: 700;
        color: #566a7f;
        margin-right: 4px;
    }

    .section-card {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(67, 89, 113, 0.08);
    }

    .section-header {
        padding: 16px 20px;
        background: #f5f5f9;
        border-bottom: 1px solid #e7e7ff;
    }

    .section-header-primary {
        background: #696cff;
        color: #fff;
    }

    .section-header-primary h5 {
        color: #fff;
    }

    .rekap-box {
        border-radius: 12px;
        padding: 18px 12px;
        text-align: center;
        height: 100%;
    }

    .rekap-box .angka {
        font-size: 1.5rem;
        font-weight: 800;
        line-height: 1;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .status-mini {
        min-width: 34px;
        padding: 6px 8px;
        font-weight: 700;
    }

    .btn-icon-sm {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .bap-textarea {
        min-height: 90px;
        resize: vertical;
    }
</style>
@endsection

@section('content')

@php
    $namaMataKuliah = data_get($kelas ?? null, 'mataKuliah.nama_mata_kuliah')
        ?? data_get($kelas ?? null, 'mataKuliah.nama_mk')
        ?? data_get($kelas ?? null, 'mataKuliah.nama')
        ?? data_get($kelas ?? null, 'mata_kuliah')
        ?? '-';

    $bapSudahDiisi = !empty($kelas->bap_diisi_pada);
    $jumlahPertemuan = isset($pertemuanList) ? $pertemuanList->count() : 0;
    $jumlahMahasiswa = isset($mahasiswaList) ? $mahasiswaList->count() : 0;
@endphp

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h3 class="page-title mb-1">
                📋 Detail Absensi dan BAP Kelas
            </h3>
            <div class="text-muted">
                {{ $kelas->nama_kelas ?? '-' }} —
                {{ $namaMataKuliah }} —
                {{ $kelas->hari ?? '-' }},
                {{ $kelas->jam_mulai ?? '-' }} - {{ $kelas->jam_selesai ?? '-' }}
            </div>
        </div>

        <a href="{{ route('dosen.kelas') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back me-1"></i>
            Kembali
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bx bx-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bx bx-error-circle me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bx bx-error-circle me-1"></i>
            <strong>Terjadi kesalahan.</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- INFORMASI KELAS --}}
    <div class="card section-card mb-4">
        <div class="card-body info-card p-4">
            <h5 class="fw-bold mb-3">Informasi Kelas</h5>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <span class="info-label">Nama Kelas:</span>
                    <span>{{ $kelas->nama_kelas ?? '-' }}</span>
                </div>

                <div class="col-md-6 mb-2">
                    <span class="info-label">Mata Kuliah:</span>
                    <span>{{ $namaMataKuliah }}</span>
                </div>

                <div class="col-md-6 mb-2">
                    <span class="info-label">Semester:</span>
                    <span>{{ $kelas->semester ?? '-' }}</span>
                </div>

                <div class="col-md-6 mb-2">
                    <span class="info-label">Dosen:</span>
                    <span>{{ $kelas->dosen ?? '-' }}</span>
                </div>

                <div class="col-md-6 mb-2">
                    <span class="info-label">Ruangan:</span>
                    <span>{{ $kelas->ruangan ?? '-' }}</span>
                </div>

                <div class="col-md-6 mb-2">
                    <span class="info-label">Hari:</span>
                    <span>{{ $kelas->hari ?? '-' }}</span>
                </div>

                <div class="col-md-6 mb-2">
                    <span class="info-label">Jam:</span>
                    <span>{{ $kelas->jam_mulai ?? '-' }} - {{ $kelas->jam_selesai ?? '-' }}</span>
                </div>

                <div class="col-md-6 mb-2">
                    <span class="info-label">Status Absen:</span>
                    @if($kelas->is_absen_open)
                        <span class="badge bg-success">Buka</span>
                    @else
                        <span class="badge bg-danger">Tutup</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- BAP --}}
    <div class="card section-card mb-4">
        <div class="section-header section-header-primary">
            <h5 class="mb-0 fw-bold">
                📝 Berita Acara Perkuliahan
            </h5>
        </div>

        <div class="card-body p-4">
            @if(!$bapSudahDiisi)
                <div class="alert alert-warning">
                    <i class="bx bx-info-circle me-1"></i>
                    BAP belum diisi. Lengkapi BAP agar data absensi memiliki catatan pelaksanaan perkuliahan.
                </div>
            @else
                <div class="alert alert-success">
                    <i class="bx bx-check-circle me-1"></i>
                    BAP sudah diisi. Dosen masih dapat memperbarui isi BAP jika diperlukan.
                </div>
            @endif

            <form action="{{ route('dosen.absensi.bap.store', $kelas->id) }}" method="POST">
                @csrf

                <input
                    type="hidden"
                    name="bap_pertemuan"
                    value="{{ old('bap_pertemuan', $kelas->bap_pertemuan ?? ($jumlahPertemuan > 0 ? $jumlahPertemuan : 1)) }}">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Materi Perkuliahan</label>
                    <textarea
                        name="bap_rangkuman"
                        class="form-control bap-textarea @error('bap_rangkuman') is-invalid @enderror"
                        placeholder="Contoh: Pembahasan materi pertemuan, diskusi tugas, atau praktik sesuai RPS."
                        required>{{ old('bap_rangkuman', $kelas->bap_rangkuman ?? '') }}</textarea>

                    @error('bap_rangkuman')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Metode Pembelajaran</label>
                    <select
                        name="bap_metode_pembelajaran"
                        class="form-select @error('bap_metode_pembelajaran') is-invalid @enderror">

                        <option value="">-- Pilih Metode Pembelajaran --</option>
                        <option value="Ceramah" {{ old('bap_metode_pembelajaran', $kelas->bap_metode_pembelajaran ?? '') == 'Ceramah' ? 'selected' : '' }}>Ceramah</option>
                        <option value="Diskusi" {{ old('bap_metode_pembelajaran', $kelas->bap_metode_pembelajaran ?? '') == 'Diskusi' ? 'selected' : '' }}>Diskusi</option>
                        <option value="Praktik" {{ old('bap_metode_pembelajaran', $kelas->bap_metode_pembelajaran ?? '') == 'Praktik' ? 'selected' : '' }}>Praktik</option>
                        <option value="Presentasi" {{ old('bap_metode_pembelajaran', $kelas->bap_metode_pembelajaran ?? '') == 'Presentasi' ? 'selected' : '' }}>Presentasi</option>
                        <option value="Tanya Jawab" {{ old('bap_metode_pembelajaran', $kelas->bap_metode_pembelajaran ?? '') == 'Tanya Jawab' ? 'selected' : '' }}>Tanya Jawab</option>
                        <option value="Lainnya" {{ old('bap_metode_pembelajaran', $kelas->bap_metode_pembelajaran ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>

                    @error('bap_metode_pembelajaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Catatan Dosen</label>
                    <textarea
                        name="bap_berita_acara"
                        class="form-control bap-textarea @error('bap_berita_acara') is-invalid @enderror"
                        placeholder="Contoh: Perkuliahan berjalan lancar, mahasiswa aktif berdiskusi, atau terdapat kendala teknis.">{{ old('bap_berita_acara', $kelas->bap_berita_acara ?? '') }}</textarea>

                    @error('bap_berita_acara')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i>
                    {{ $bapSudahDiisi ? 'Perbarui BAP' : 'Simpan BAP' }}
                </button>
            </form>
        </div>
    </div>

    {{-- REKAP --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="rekap-box bg-success bg-opacity-10">
                <div class="angka text-success">{{ $totalHadir ?? 0 }}</div>
                <small class="text-success">Hadir</small>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="rekap-box bg-info bg-opacity-10">
                <div class="angka text-info">{{ $totalIzin ?? 0 }}</div>
                <small class="text-info">Izin</small>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="rekap-box bg-warning bg-opacity-10">
                <div class="angka text-warning">{{ $totalSakit ?? 0 }}</div>
                <small class="text-warning">Sakit</small>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="rekap-box bg-danger bg-opacity-10">
                <div class="angka text-danger">{{ $totalAlpha ?? 0 }}</div>
                <small class="text-danger">Alfa</small>
            </div>
        </div>
    </div>

    {{-- TAMBAH MAHASISWA --}}
    <div class="card section-card mb-4">
        <div class="section-header">
            <h5 class="fw-bold mb-0">Tambah Mahasiswa ke Kelas</h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('dosen.kelas.mahasiswa.tambah', $kelas->id) }}" method="POST">
                @csrf

                <div class="row g-2 align-items-center">
                    <div class="col-md-10">
                        <select name="mahasiswa_id" class="form-select" required>
                            <option value="">-- Pilih Mahasiswa --</option>
                            @foreach($semuaMahasiswa as $mhs)
                                <option value="{{ $mhs->id }}">
                                    {{ $mhs->name }} — {{ $mhs->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bx bx-plus me-1"></i>
                            Tambah
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- DAFTAR ABSENSI --}}
    <div class="card section-card">
        <div class="section-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="fw-bold mb-0">Daftar Absensi Mahasiswa</h5>

            <div>
                <span class="badge bg-label-primary">
                    {{ $jumlahMahasiswa }} mahasiswa
                </span>
                <span class="badge bg-label-secondary">
                    {{ $jumlahPertemuan }} pertemuan
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Mahasiswa</th>

                            @foreach($pertemuanList as $i => $p)
                                <th class="text-center">
                                    P{{ $i + 1 }}<br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($p->tanggal)->format('d/m') }}
                                    </small>
                                </th>
                            @endforeach

                            <th class="text-center">Kehadiran</th>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($mahasiswaList as $idx => $km)
                            @php
                                $mhs = $km->mahasiswa;
                                $hadir = 0;
                                $totalPertemuan = $jumlahPertemuan;
                            @endphp

                            <tr>
                                <td>{{ $idx + 1 }}</td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ strtoupper($mhs->name ?? '-') }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $mhs->email ?? '-' }}
                                    </small>
                                </td>

                                @foreach($pertemuanList as $p)
                                    @php
                                        $status = $absensiData[$mhs->id][$p->pertemuan_ke] ?? null;

                                        if ($status === 'H') {
                                            $hadir++;
                                        }
                                    @endphp

                                    <td class="text-center">
                                        @if($status === 'H')
                                            <span class="badge bg-success status-mini">H</span>
                                        @elseif($status === 'I')
                                            <span class="badge bg-info status-mini">I</span>
                                        @elseif($status === 'S')
                                            <span class="badge bg-warning text-dark status-mini">S</span>
                                        @elseif($status === 'A')
                                            <span class="badge bg-danger status-mini">A</span>
                                        @else
                                            <span class="badge bg-secondary status-mini">-</span>
                                        @endif
                                    </td>
                                @endforeach

                                <td class="text-center">
                                    @php
                                        $pct = $totalPertemuan > 0 ? round(($hadir / $totalPertemuan) * 100) : 0;
                                    @endphp

                                    <div class="fw-bold">{{ $pct }}%</div>
                                    <small class="text-muted">
                                        {{ $hadir }}/{{ $totalPertemuan }}
                                    </small>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('dosen.absensi.edit-mahasiswa', [$kelas->id, $mhs->id]) }}"
                                           class="btn btn-sm btn-primary btn-icon-sm"
                                           title="Edit absensi">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <form action="{{ route('dosen.absensi.hapus-mahasiswa', [$kelas->id, $mhs->id]) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus mahasiswa ini dari kelas?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger btn-icon-sm"
                                                    title="Hapus mahasiswa">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $jumlahPertemuan + 4 }}" class="text-center text-muted py-4">
                                    <i class="bx bx-user-x fs-3 d-block mb-2"></i>
                                    Belum ada mahasiswa di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="text-muted small mt-3">
        <i class="bx bx-info-circle me-1"></i>
        Total {{ $jumlahMahasiswa }} mahasiswa terdaftar.
        Mahasiswa yang belum absen otomatis berstatus <strong>Alfa</strong>.
        BAP digunakan sebagai catatan resmi pelaksanaan kelas biasa.
    </div>

</div>

@endsection
