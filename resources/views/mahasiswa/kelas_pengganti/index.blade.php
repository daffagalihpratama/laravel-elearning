@extends('layouts/contentNavbarLayout')

@section('title', 'Kelas Pengganti')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Kelas Pengganti 🔄</h4>
        <small class="text-muted">
            Daftar kelas pengganti yang sudah disetujui dan dapat diikuti oleh mahasiswa.
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
        @forelse($kelasPengganti as $item)
            @php
                $namaMataKuliah = data_get($item, 'kelas_asli.mataKuliah.nama_mata_kuliah')
                    ?? data_get($item, 'kelas_asli.mataKuliah.nama_mk')
                    ?? data_get($item, 'kelas_asli.mataKuliah.nama')
                    ?? data_get($item, 'kelas.mataKuliah.nama_mata_kuliah')
                    ?? data_get($item, 'kelas.mataKuliah.nama_mk')
                    ?? data_get($item, 'kelas.mataKuliah.nama')
                    ?? data_get($item, 'nama_mata_kuliah')
                    ?? data_get($item, 'mata_kuliah')
                    ?? '-';

                $bap = $item->bap_mahasiswa ?? $item->bap ?? null;
                $absensi = $item->absensi_mahasiswa ?? null;

                $statusAbsensi = $absensi->status ?? null;

                $sudahAbsen = in_array($statusAbsensi, ['Hadir', 'Izin', 'Sakit']);

                $labelStatusAbsensi = 'Belum Dibuka';
                $badgeStatusAbsensi = 'bg-secondary';

                if ($statusAbsensi === 'Hadir') {
                    $labelStatusAbsensi = 'Hadir';
                    $badgeStatusAbsensi = 'bg-success';
                } elseif ($statusAbsensi === 'Izin') {
                    $labelStatusAbsensi = 'Izin';
                    $badgeStatusAbsensi = 'bg-info';
                } elseif ($statusAbsensi === 'Sakit') {
                    $labelStatusAbsensi = 'Sakit';
                    $badgeStatusAbsensi = 'bg-warning text-dark';
                } elseif ($statusAbsensi === 'Alfa') {
                    $labelStatusAbsensi = 'Belum Absen';
                    $badgeStatusAbsensi = 'bg-danger';
                }

                $labelStatusBap = $bap ? 'Sudah Diisi' : 'Belum Diisi';
                $badgeStatusBap = $bap ? 'bg-success' : 'bg-warning text-dark';

                $tanggalGanti = $item->tanggal_ganti_kp
                    ? \Carbon\Carbon::parse($item->tanggal_ganti_kp)->format('d M Y')
                    : '-';

                $tanggalPengganti = $item->tanggal_pengganti
                    ? \Carbon\Carbon::parse($item->tanggal_pengganti)->format('d M Y')
                    : '-';

                $jamMulai = $item->jam_mulai
                    ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i')
                    : '-';

                $jamSelesai = $item->jam_selesai
                    ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i')
                    : '-';
            @endphp

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-3">

                    {{-- Card Header --}}
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-1 fw-bold">{{ $namaMataKuliah }}</h5>
                        <small>
                            {{ $item->nama_kelas ?? '-' }} | Semester {{ $item->semester ?? '-' }}
                        </small>
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

                            <p class="mb-2">
                                🏫 <strong>Ruangan:</strong> {{ $item->ruangan ?? '-' }}
                            </p>

                            <p class="mb-2">
                                📌 <strong>Tanggal Ganti KP:</strong> {{ $tanggalGanti }}
                            </p>

                            <p class="mb-2">
                                📆 <strong>Tanggal Pengganti:</strong> {{ $tanggalPengganti }}
                            </p>

                            <p class="mb-0">
                                📝 <strong>Alasan:</strong> {{ $item->alasan ?? '-' }}
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

                        {{-- Tombol Masuk Kelas --}}
                        <div class="mt-auto">
                            <a href="{{ route('mahasiswa.kelas_pengganti.detail', $item->id) }}"
                               class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center py-2">
                                <i class="bx bx-log-in-circle me-2"></i>
                                Masuk Kelas
                            </a>

                            @if($statusAbsensi === 'Alfa')
                                <small class="d-block text-center mt-2 text-muted">
                                    Kamu belum absen. Masuk kelas untuk melakukan absensi.
                                </small>
                            @elseif($sudahAbsen)
                                <small class="d-block text-center mt-2 text-muted">
                                    Kamu sudah absen. Masuk kelas untuk melihat detail dan BAP.
                                </small>
                            @elseif(!$absensi)
                                <small class="d-block text-center mt-2 text-muted">
                                    Absensi belum dibuka. Kamu tetap dapat melihat detail kelas.
                                </small>
                            @else
                                <small class="d-block text-center mt-2 text-muted">
                                    Klik untuk melihat detail kelas pengganti.
                                </small>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bx bx-calendar-x me-1"></i>
                    Belum ada kelas pengganti yang tersedia.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
