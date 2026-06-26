@extends('layouts.contentNavbarLayout')

@section('content')
<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4">

        <h3 class="fw-bold mb-4">👥 Kelola Mahasiswa per Kelas</h3>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Mata Kuliah</th>
                        <th>Semester</th>
                        <th>Dosen</th>
                        <th>Jumlah Mahasiswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $k)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->mataKuliah->nama_mk ?? '-' }}</td>
                        <td>Semester {{ $k->semester }}</td>
                        <td>{{ $k->dosen }}</td>
                        <td>
                            <span class="badge bg-primary rounded-pill">
                                {{ $k->kelasMahasiswa->count() }} Mahasiswa
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.kelas_mahasiswa.show', $k->id) }}" class="btn btn-sm btn-primary">
                                <i class="bx bx-group me-1"></i> Kelola Mahasiswa
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada kelas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
