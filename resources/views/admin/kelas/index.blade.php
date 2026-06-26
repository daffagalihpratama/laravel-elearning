@extends('layouts/contentNavbarLayout')

@section('title', 'Data Kelas')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="fw-bold">
            Data Kelas 🏫
        </h4>

        <a href="/admin/kelas/create"
           class="btn btn-primary">

            <i class="bx bx-plus"></i>
            Tambah Kelas

        </a>

    </div>

    <div class="row">

        @foreach ($kelas as $item)

        <div class="col-md-4 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h4 class="mb-3">
                        {{ $item->nama_kelas }}
                    </h4>

                    <p class="mb-1">
                        <strong>Mata Kuliah:</strong>
                        {{ $item->mataKuliah->nama_mk ?? '-' }}
                    </p>

                    <p class="mb-1">
                        <strong>Semester:</strong>
                        {{ $item->semester }}
                    </p>

                    <p class="mb-1">
                        <strong>Dosen:</strong>
                        {{ $item->dosen }}
                    </p>

                    <p class="mb-1">
                        <strong>Hari:</strong>
                        {{ $item->hari ?? '-' }}
                    </p>

                    <p class="mb-1">
                        <strong>Jam:</strong>
                        {{ $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '-' }}
                        –
                        {{ $item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-' }}
                    </p>

                    <p class="mb-3">
                        <strong>Ruangan:</strong>
                        {{ $item->ruangan ?? '-' }}
                    </p>

                    <div class="mb-3">

                        @if($item->status == 'pending')

                            <span class="badge bg-warning">
                                Pending
                            </span>

                        @elseif($item->status == 'approved')

                            <span class="badge bg-success">
                                Approved
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Rejected
                            </span>

                        @endif

                    </div>

                    <div class="d-flex flex-wrap gap-2">

                        @if($item->status == 'pending')

                            <form action="{{ route('kelas.approve', $item->id) }}"
                                  method="POST">

                                @csrf

                                <button type="submit"
                                        class="btn btn-success btn-sm">

                                    Approve

                                </button>

                            </form>

                            <form action="{{ route('kelas.reject', $item->id) }}"
                                  method="POST">

                                @csrf

                                <button type="submit"
                                        class="btn btn-danger btn-sm">

                                    Reject

                                </button>

                            </form>

                        @endif

                        <a href="/admin/kelas/{{ $item->id }}/edit"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form action="/admin/kelas/{{ $item->id }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-secondary btn-sm">

                                Hapus

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection
