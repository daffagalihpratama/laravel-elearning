@extends('layouts.contentNavbarLayout')

@section('content')

@php
    $namaMataKuliah = data_get($kelas ?? null, 'mataKuliah.nama_mata_kuliah')
        ?? data_get($kelas ?? null, 'mataKuliah.nama_mk')
        ?? data_get($kelas ?? null, 'mataKuliah.nama')
        ?? data_get($kelasPengganti ?? null, 'nama_mata_kuliah')
        ?? data_get($kelasPengganti ?? null, 'mata_kuliah')
        ?? '-';
@endphp

<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4">

        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('dosen.kelas_pengganti') }}" class="btn btn-sm btn-secondary">
                <i class="bx bx-arrow-back"></i>
            </a>

            <div>
                <h3 class="fw-bold mb-0">
                    📋 Absensi dan BAP Kelas Pengganti
                    @if($namaMataKuliah !== '-')
                        - {{ $namaMataKuliah }}
                    @endif
                </h3>

                <small class="text-muted">
                    {{ $kelasPengganti->nama_kelas }} —
                    {{ $namaMataKuliah }} —
                    {{ $kelasPengganti->hari }},
                    {{ \Carbon\Carbon::parse($kelasPengganti->tanggal_pengganti)->format('d M Y') }}
                </small>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
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

        {{-- Informasi Kelas Pengganti --}}
        <div class="card border-0 bg-light mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Informasi Kelas Pengganti</h5>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>Nama Kelas:</strong>
                        <span>{{ $kelasPengganti->nama_kelas }}</span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Mata Kuliah:</strong>
                        <span>{{ $namaMataKuliah }}</span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Semester:</strong>
                        <span>{{ $kelasPengganti->semester }}</span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Dosen:</strong>
                        <span>{{ $kelasPengganti->dosen }}</span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Ruangan:</strong>
                        <span>{{ $kelasPengganti->ruangan ?? '-' }}</span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Ganti KP:</strong>
                        <span>
                            {{ $kelasPengganti->tanggal_ganti_kp ? \Carbon\Carbon::parse($kelasPengganti->tanggal_ganti_kp)->format('d M Y') : '-' }}
                        </span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Pengganti:</strong>
                        <span>
                            {{ $kelasPengganti->tanggal_pengganti ? \Carbon\Carbon::parse($kelasPengganti->tanggal_pengganti)->format('d M Y') : '-' }}
                        </span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Jam:</strong>
                        <span>{{ $kelasPengganti->jam_mulai }} - {{ $kelasPengganti->jam_selesai }}</span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Status:</strong>
                        <span class="badge bg-success">Approved</span>
                    </div>

                    <div class="col-12 mt-2">
                        <strong>Alasan:</strong>
                        <span>{{ $kelasPengganti->alasan }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAP Kelas Pengganti --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 fw-bold">📝 Berita Acara Perkuliahan</h5>
            </div>

            <div class="card-body">
                @if(!$bap)
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

                <form action="{{ route('dosen.kelas_pengganti.bap.store', $kelasPengganti->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Materi Perkuliahan</label>
                        <textarea
                            name="materi"
                            class="form-control @error('materi') is-invalid @enderror"
                            rows="3"
                            placeholder="Contoh: Pembahasan materi pertemuan, diskusi tugas, atau praktik sesuai RPS."
                            required
                        >{{ old('materi', $bap->materi ?? '') }}</textarea>

                        @error('materi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Metode Pembelajaran</label>
                        <select
                            name="metode_pembelajaran"
                            class="form-select @error('metode_pembelajaran') is-invalid @enderror"
                        >
                            <option value="">-- Pilih Metode Pembelajaran --</option>
                            <option value="Ceramah" {{ old('metode_pembelajaran', $bap->metode_pembelajaran ?? '') == 'Ceramah' ? 'selected' : '' }}>Ceramah</option>
                            <option value="Diskusi" {{ old('metode_pembelajaran', $bap->metode_pembelajaran ?? '') == 'Diskusi' ? 'selected' : '' }}>Diskusi</option>
                            <option value="Praktik" {{ old('metode_pembelajaran', $bap->metode_pembelajaran ?? '') == 'Praktik' ? 'selected' : '' }}>Praktik</option>
                            <option value="Presentasi" {{ old('metode_pembelajaran', $bap->metode_pembelajaran ?? '') == 'Presentasi' ? 'selected' : '' }}>Presentasi</option>
                            <option value="Tanya Jawab" {{ old('metode_pembelajaran', $bap->metode_pembelajaran ?? '') == 'Tanya Jawab' ? 'selected' : '' }}>Tanya Jawab</option>
                            <option value="Lainnya" {{ old('metode_pembelajaran', $bap->metode_pembelajaran ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>

                        @error('metode_pembelajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan Dosen</label>
                        <textarea
                            name="catatan_dosen"
                            class="form-control @error('catatan_dosen') is-invalid @enderror"
                            rows="3"
                            placeholder="Contoh: Perkuliahan berjalan lancar, mahasiswa aktif berdiskusi, atau terdapat kendala teknis."
                        >{{ old('catatan_dosen', $bap->catatan_dosen ?? '') }}</textarea>

                        @error('catatan_dosen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i>
                        {{ $bap ? 'Perbarui BAP' : 'Simpan BAP' }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Rekap Singkat --}}
        @php
            $totalHadir = $rekap['hadir'] ?? $absensi->where('status', 'Hadir')->count();
            $totalIzin  = $rekap['izin'] ?? $absensi->where('status', 'Izin')->count();
            $totalSakit = $rekap['sakit'] ?? $absensi->where('status', 'Sakit')->count();
            $totalAlfa  = $rekap['alfa'] ?? $absensi->where('status', 'Alfa')->count();
            $total      = $rekap['total'] ?? $absensi->count();
        @endphp

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 bg-success bg-opacity-10 text-center py-3">
                    <div class="fw-bold fs-4 text-success">{{ $totalHadir }}</div>
                    <small class="text-success">Hadir</small>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card border-0 bg-info bg-opacity-10 text-center py-3">
                    <div class="fw-bold fs-4 text-info">{{ $totalIzin }}</div>
                    <small class="text-info">Izin</small>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card border-0 bg-warning bg-opacity-10 text-center py-3">
                    <div class="fw-bold fs-4 text-warning">{{ $totalSakit }}</div>
                    <small class="text-warning">Sakit</small>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card border-0 bg-danger bg-opacity-10 text-center py-3">
                    <div class="fw-bold fs-4 text-danger">{{ $totalAlfa }}</div>
                    <small class="text-danger">Alfa</small>
                </div>
            </div>
        </div>

        {{-- Tabel Absensi --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="fw-bold mb-0">Daftar Absensi Mahasiswa</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                <th>Status Saat Ini</th>
                                <th>Ubah Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($absensi as $a)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <span class="fw-semibold">{{ $a->mahasiswa->name ?? '-' }}</span>
                                    </td>

                                    <td>
                                        @if($a->status == 'Hadir')
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="bx bx-check-circle me-1"></i> Hadir
                                            </span>
                                        @elseif($a->status == 'Izin')
                                            <span class="badge bg-info px-3 py-2">
                                                <i class="bx bx-clipboard me-1"></i> Izin
                                            </span>
                                        @elseif($a->status == 'Sakit')
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                <i class="bx bx-plus-medical me-1"></i> Sakit
                                            </span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2">
                                                <i class="bx bx-x-circle me-1"></i> Alfa
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <form action="{{ route('dosen.kelas_pengganti.absensi.update', $a->id) }}" method="POST" class="d-flex gap-2">
    @csrf
    @method('PUT')

    <select name="status" class="form-select form-select-sm" style="width: 130px;">
        <option value="Hadir" {{ $a->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
        <option value="Izin" {{ $a->status == 'Izin' ? 'selected' : '' }}>Izin</option>
        <option value="Sakit" {{ $a->status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
        <option value="Alfa" {{ $a->status == 'Alfa' ? 'selected' : '' }}>Alfa</option>
    </select>

    <button type="submit" class="btn btn-sm btn-primary">
        Simpan
    </button>
</form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bx bx-user-x fs-3 d-block mb-2"></i>
                                        Belum ada mahasiswa terdaftar di kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Footer info --}}
        <div class="text-muted small mt-3">
            <i class="bx bx-info-circle me-1"></i>
            Total {{ $total }} mahasiswa terdaftar.
            Mahasiswa yang belum absen otomatis berstatus <strong>Alfa</strong>.
            BAP digunakan sebagai catatan resmi pelaksanaan kelas pengganti.
        </div>

    </div>
</div>
@endsection
