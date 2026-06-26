@extends('layouts.contentNavbarLayout')

@section('content')

<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">📚 Daftar Kelas</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Status Absen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $k)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $k->nama_kelas }}</td>
                    <td>{{ $k->mataKuliah->nama_mk ?? '-' }}</td>
                    <td>{{ $k->hari }}</td>
                    <td>{{ $k->jam_mulai }} - {{ $k->jam_selesai }}</td>
                    <td>
                        @if($k->is_absen_open)
                            <span class="badge bg-success">Buka</span>
                        @else
                            <span class="badge bg-secondary">Tutup</span>
                        @endif
                    </td>
                    <td>
                        @if($k->is_absen_open)
                            <a href="{{ route('dosen.absensi.tutup', $k->id) }}"
                               class="btn btn-sm btn-danger">Tutup Absen</a>
                        @else
                            <a href="{{ route('dosen.absensi.buka', $k->id) }}"
                               class="btn btn-sm btn-success">Buka Absen</a>
                        @endif
                        <a href="{{ route('dosen.absensi.detail', $k->id) }}"
                           class="btn btn-sm btn-primary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada kelas</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection
