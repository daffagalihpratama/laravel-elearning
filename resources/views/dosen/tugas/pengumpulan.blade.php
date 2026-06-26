@extends('layouts/contentNavbarLayout')

@section('title', 'Pengumpulan Tugas')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

```
<!-- Header -->
<div class="mb-4">
    <h4 class="fw-bold">
        📥 Pengumpulan Tugas
    </h4>

    <p class="text-muted mb-0">
        {{ $tugas->judul }}
    </p>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Info Tugas -->
<div class="card mb-4">

    <div class="card-body">

        <div class="row">

            <div class="col-md-4">
                <small class="text-muted">Judul Tugas</small>
                <h6>{{ $tugas->judul }}</h6>
            </div>

            <div class="col-md-4">
                <small class="text-muted">Deadline</small>
                <h6>
                    {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y') }}
                </h6>
            </div>

            <div class="col-md-4">
                <small class="text-muted">Total Pengumpulan</small>
                <h6>{{ $pengumpulan->count() }} Mahasiswa</h6>
            </div>

        </div>

    </div>

</div>

<!-- Data Pengumpulan -->
<div class="card">

    <div class="card-header">
        <h5 class="mb-0">
            Daftar Pengumpulan Mahasiswa
        </h5>
    </div>

    <div class="table-responsive">

        <table class="table table-hover">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>Link Jawaban</th>
                    <th>Status</th>
                    <th>Nilai</th>
                    <th width="250">Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($pengumpulan as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        <strong>
                            {{ $item->mahasiswa->name ?? '-' }}
                        </strong>
                    </td>

                    <td>

                        @if($item->link_jawaban)

                            <a href="{{ $item->link_jawaban }}"
                               target="_blank"
                               class="btn btn-info btn-sm">

                                🔗 Lihat Jawaban

                            </a>

                        @else

                            <span class="badge bg-danger">
                                Tidak Ada Link
                            </span>

                        @endif

                    </td>

                    <td>

                        <span class="badge bg-success">
                            {{ $item->status }}
                        </span>

                    </td>

                    <td>

                        @if($item->nilai)

                            <span class="badge bg-primary">
                                {{ $item->nilai }}
                            </span>

                        @else

                            <span class="badge bg-warning">
                                Belum Dinilai
                            </span>

                        @endif

                    </td>

                    <td>

                        <form
                            action="{{ route('dosen.tugas.nilai', $item->id) }}"
                            method="POST"
                            class="d-flex gap-2">

                            @csrf

                            <input
                                type="number"
                                name="nilai"
                                min="0"
                                max="100"
                                value="{{ $item->nilai }}"
                                class="form-control">

                            <button
                                type="submit"
                                class="btn btn-success">

                                Simpan

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="text-center py-4">
                        Belum ada mahasiswa yang mengumpulkan tugas.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>
```

</div>

@endsection
