@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Tugas')

@section('content')

<div class="container-xxl container-p-y">

    <div class="card p-4">

        <h4 class="mb-3">Edit Tugas</h4>

        <form action="/admin/tugas/{{ $tugas->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul"
                       value="{{ $tugas->judul }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi"
                          class="form-control">{{ $tugas->deskripsi }}</textarea>
            </div>

            <div class="mb-3">
                <label>Deadline</label>
                <input type="date"
                       name="deadline"
                       value="{{ $tugas->deadline }}"
                       class="form-control">
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="/admin/tugas" class="btn btn-secondary">Kembali</a>

        </form>

    </div>

</div>

@endsection
