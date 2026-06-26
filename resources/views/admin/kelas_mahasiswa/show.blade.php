@extends('layouts.contentNavbarLayout')

@section('content')
<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4">

        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('admin.kelas_mahasiswa') }}" class="btn btn-sm btn-secondary">
                <i class="bx bx-arrow-back"></i>
            </a>
            <h3 class="fw-bold mb-0">👥 {{ $kelas->nama_kelas }} — Semester {{ $kelas->semester }}</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Form tambah mahasiswa --}}
        <div class="card border mb-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Tambah Mahasiswa ke Kelas</h6>
                <form action="{{ route('admin.kelas_mahasiswa.tambah', $kelas->id) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <select name="mahasiswa_id" class="form-select" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($semuaMahasiswa as $m)
                            <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary px-4">Tambah</button>
                </form>
            </div>
        </div>

        {{-- List mahasiswa terdaftar --}}
        <h6 class="fw-semibold mb-3">Mahasiswa Terdaftar ({{ $mahasiswaTerdaftar->count() }})</h6>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswaTerdaftar as $km)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $km->mahasiswa->name }}</td>
                        <td>{{ $km->mahasiswa->email }}</td>
                        <td>
                            <form action="{{ route('admin.kelas_mahasiswa.hapus', [$kelas->id, $km->mahasiswa_id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Hapus mahasiswa ini dari kelas?')">
                                    <i class="bx bx-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada mahasiswa di kelas ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
