@extends('layouts/contentNavbarLayout')

@section('title', 'Tugas Mahasiswa')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold mb-4">Tugas Saya 📚</h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Daftar Tugas</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Deadline</th>
                        <th>Lampiran</th>
                        <th>Status</th>
                        <th>Nilai</th>
                        <th width="300">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($tugas as $t)
                    @php
                        // SAFE: ambil submission mahasiswa
                        $pengumpulan = $t->pengumpulans->first();
                    @endphp

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <strong>{{ $t->judul }}</strong>
                        </td>

                        <td>
                            {{ \Illuminate\Support\Str::limit($t->deskripsi, 80) }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($t->deadline)->format('d M Y') }}
                        </td>

                        <td>
                            @if($t->lampiran)
                                <a href="{{ asset('storage/' . $t->lampiran) }}"
                                   target="_blank"
                                   class="btn btn-info btn-sm">
                                    <i class="bx bx-download me-1"></i> Download
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>
                            @if(!$pengumpulan)
                                <span class="badge bg-label-danger">Belum Dikumpulkan</span>
                            @elseif(is_null($pengumpulan->nilai))
                                <span class="badge bg-label-warning">Menunggu Penilaian</span>
                            @else
                                <span class="badge bg-label-success">Sudah Dinilai</span>
                            @endif
                        </td>

                        <td>
                            {{ $pengumpulan->nilai ?? '-' }}
                        </td>

                        <td>
                            @if(!$pengumpulan)
                                <form action="{{ route('mahasiswa.tugas.submit', $t->id) }}" method="POST">
                                    @csrf
                                    <input
                                        type="url"
                                        name="link_jawaban"
                                        class="form-control mb-2"
                                        placeholder="https://drive.google.com/..."
                                        required
                                    >
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Kumpulkan Tugas
                                    </button>
                                </form>
                            @else
                                <div class="d-flex gap-2">
                                    <a href="{{ $pengumpulan->link_jawaban }}"
                                       target="_blank"
                                       class="btn btn-success btn-sm">
                                        Lihat Jawaban
                                    </a>

                                    @if($t->lampiran)
                                        <a href="{{ asset('storage/' . $t->lampiran) }}"
                                           target="_blank"
                                           class="btn btn-info btn-sm">
                                            Lampiran
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Belum ada tugas
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
