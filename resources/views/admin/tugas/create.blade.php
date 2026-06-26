@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Tugas')

@section('content')

<div class="container-xxl container-p-y">

    <div class="card p-4">

        <h4 class="mb-3">Tambah Tugas</h4>

        <form action="/admin/tugas" method="POST">
            @csrf

            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label>Deadline</label>
                <input type="date" name="deadline" class="form-control" required>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="/admin/tugas" class="btn btn-secondary">Kembali</a>

        </form>

    </div>

</div>

@endsection
