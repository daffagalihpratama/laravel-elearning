@extends('layouts/contentNavbarLayout')

@section('title', 'Materi')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h4>Daftar Materi</h4>

        <a href="{{ route('dosen.materi.create') }}"
           class="btn btn-primary">

            + Tambah Materi

        </a>

    </div>

    <div class="table-responsive">

        <table class="table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Pertemuan</th>
                    <th>Judul</th>
                    <th>File</th>
                </tr>
            </thead>

            <tbody>

                @foreach($materi as $m)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $m->kelas->nama_kelas }}</td>

                    <td>{{ $m->pertemuan }}</td>

                    <td>{{ $m->judul }}</td>

                    <td>

                        @if($m->file)

                        <a href="{{ asset('materi/'.$m->file) }}"
                           target="_blank">

                           Download

                        </a>

                        @endif

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection
