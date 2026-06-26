@extends('layouts.contentNavbarLayout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Akademik /</span> Data Nilai 📊
        </h4>

        @if($periodeDibuka)
            <a href="{{ route('dosen.nilai.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Tambah Nilai
            </a>
        @else
            <button class="btn btn-secondary" disabled>
                <i class="bx bx-lock-alt me-1"></i> Tambah Nilai
            </button>
        @endif
    </div>

    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Alert error --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Status periode --}}
    @if($periodeDibuka)
        <div class="alert alert-success mb-4">
            Periode input nilai sedang dibuka
            @if($periodeAktif)
                sampai <strong>{{ \Carbon\Carbon::parse($periodeAktif->deadline_input)->format('d-m-Y H:i') }}</strong>
            @endif
        </div>
    @else
        <div class="alert alert-danger mb-4">
            Periode input nilai sedang ditutup atau belum dibuka oleh admin.
        </div>
    @endif

    {{-- Tabel --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>NO</th>
                            <th>MAHASISWA</th>
                            <th>KELAS</th>
                            <th>MATA KULIAH</th>
                            <th>NILAI AKHIR</th>
                            <th>GRADE</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($nilais as $index => $nilai)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $nilai->mahasiswa->name ?? $nilai->mahasiswa ?? '-' }}</td>
                                <td>{{ $nilai->kelas }}</td>
                                <td>{{ $nilai->mata_kuliah }}</td>
                                <td>{{ $nilai->nilai_akhir }}</td>
                                <td>
                                    <span class="badge bg-label-primary">{{ $nilai->grade }}</span>
                                </td>
                                <td>
                                    @if ($nilai->status === 'Lulus')
                                        <span class="badge bg-success">Lulus</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Lulus</span>
                                    @endif
                                </td>
                                <td>
                                    @if($periodeDibuka)
                                        <a href="{{ route('dosen.nilai.edit', $nilai->id) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bx bx-edit"></i> Edit
                                        </a>

                                        <form action="{{ route('dosen.nilai.destroy', $nilai->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin hapus nilai ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bx bx-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>
                                            <i class="bx bx-edit"></i> Edit
                                        </button>

                                        <button class="btn btn-sm btn-secondary" disabled>
                                            <i class="bx bx-trash"></i> Hapus
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data nilai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
