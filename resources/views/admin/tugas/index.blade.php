@extends('layouts/contentNavbarLayout')

@section('title', 'Data Tugas')

@section('content')

<div class="container-xxl container-p-y">

    <div class="d-flex justify-content-between mb-3">
        <h4>Data Tugas 📚</h4>

        <a href="/admin/tugas/create" class="btn btn-primary">
            Tambah Tugas
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deadline</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($tugas as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $t->judul }}</td>
                        <td>{{ $t->deadline }}</td>

                        <td>
                            <a href="/admin/tugas/{{ $t->id }}/edit"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="/admin/tugas/{{ $t->id }}"
                                  method="POST"
                                  style="display:inline">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
