@extends('layouts/contentNavbarLayout')

@section('title', 'Tugas Dosen')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">📚 Manajemen Tugas</h4>
            <small class="text-muted">
                Kelola tugas dan pantau pengumpulan mahasiswa
            </small>
        </div>
        <a href="{{ route('dosen.tugas.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i>
            Buat Tugas
        </a>
    </div>

    <!-- STATISTIK -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <span class="text-muted">Total Tugas</span>
                    <h2 class="mb-0">{{ $tugas->count() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <span class="text-muted">Tugas Aktif</span>
                    <h2 class="mb-0 text-success">
                        {{ $tugas->where('deadline', '>=', now())->count() }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <span class="text-muted">Tugas Selesai</span>
                    <h2 class="mb-0 text-danger">
                        {{ $tugas->where('deadline', '<', now())->count() }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL -->
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Daftar Tugas</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kelas</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th width="250">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugas as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->judul }}</strong>
                                <br>
                                <small class="text-muted">
                                    {{ \Illuminate\Support\Str::limit($item->deskripsi, 50) }}
                                </small>

                                <br>

                                @if($item->lampiran)
                                    <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank" class="btn btn-sm btn-info mt-2">
                                        <i class="bx bx-download"></i>
                                        Download Lampiran
                                    </a>
                                @else
                                    <small class="text-muted d-block mt-2">
                                        Tidak ada lampiran
                                    </small>
                                @endif
                            </td>

                            <td>
                                {{ $item->kelas->nama_kelas ?? '-' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}
                            </td>

                            <td>
                                @if($item->deadline >= now())
                                    <span class="badge bg-label-success">Aktif</span>
                                @else
                                    <span class="badge bg-label-danger">Berakhir</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('dosen.tugas.pengumpulan', $item->id) }}" class="btn btn-info btn-sm">
                                        <i class="bx bx-folder-open"></i>
                                    </a>

                                    <a href="{{ route('dosen.tugas.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bx bx-edit"></i>
                                    </a>

                                    <form action="{{ route('dosen.tugas.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus tugas?')">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Belum ada tugas dibuat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
