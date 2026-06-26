@extends('layouts/contentNavbarLayout')

@section('title', 'Data Nilai')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Data Nilai 📊</h4>

        <a href="{{ route('nilai.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Tambah Nilai
        </a>
    </div>

    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">
                Rekap Nilai Mahasiswa
            </h5>
        </div>

        <div class="table-responsive">

            <table class="table table-hover">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Mahasiswa</th>
                        <th>Kelas</th>
                        <th>Mata Kuliah</th>

                        <th>Tugas</th>
                        <th>UTS</th>
                        <th>UAS</th>

                        <th>Nilai Akhir</th>
                        <th>Grade</th>
                        <th>Status</th>

                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($nilais as $nilai)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{-- Coba ambil dari relasi dulu, fallback ke kolom mahasiswa --}}
                            {{ $nilai->mahasiswa->name ?? $nilai->mahasiswa ?? '-' }}
                        </td>

                        <td>{{ $nilai->kelas }}</td>

                        <td>
                            {{ $nilai->mata_kuliah }}
                        </td>

                        <td>
                            <span class="badge bg-label-info">
                                {{ $nilai->nilai_tugas }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-label-warning">
                                {{ $nilai->nilai_uts }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-label-primary">
                                {{ $nilai->nilai_uas }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-label-dark">
                                {{ $nilai->nilai_akhir }}
                            </span>
                        </td>

                        <td>

                            @if($nilai->grade == 'A')
                                <span class="badge bg-success">
                                    A
                                </span>

                            @elseif($nilai->grade == 'B')
                                <span class="badge bg-primary">
                                    B
                                </span>

                            @elseif($nilai->grade == 'C')
                                <span class="badge bg-warning">
                                    C
                                </span>

                            @else
                                <span class="badge bg-danger">
                                    D
                                </span>
                            @endif

                        </td>

                        <td>

                            @if($nilai->status == 'Lulus')

                                <span class="badge bg-label-success">
                                    Lulus
                                </span>

                            @else

                                <span class="badge bg-label-danger">
                                    Tidak Lulus
                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="d-flex gap-1">

                                <a href="{{ route('nilai.edit', $nilai->id) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bx bx-edit"></i>

                                </a>

                                <form action="{{ route('nilai.destroy', $nilai->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus data ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">

                                        <i class="bx bx-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="11" class="text-center py-4">

                            <div class="text-muted">

                                Belum ada data nilai

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
