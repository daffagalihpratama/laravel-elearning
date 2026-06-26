@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Kelas')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-body">

            <h4 class="mb-4">Tambah Kelas</h4>

            <form action="/admin/kelas" method="POST">

                @csrf

                <div class="mb-3">
                    <label>Mata Kuliah</label>
                    <select name="mata_kuliah_id" class="form-select">
                        <option value="">— Pilih Mata Kuliah —</option>
                        @foreach($matakuliah as $mk)
                            <option value="{{ $mk->id }}">{{ $mk->nama_mk }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Nama Kelas</label>
                    <input type="text" name="nama_kelas" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Semester</label>
                    <input type="text" name="semester" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Dosen</label>
                    <select name="dosen" class="form-select">
                        <option value="">— Pilih Dosen —</option>
                        @foreach($dosens as $d)
                            <option value="{{ $d->name }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>

                <hr class="my-4">
                <h6 class="mb-3 text-muted">Jadwal Kelas</h6>

                <div class="mb-3">
                    <label>Hari</label>
                    <select name="hari" class="form-select">
                        <option value="">— Pilih Hari —</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
    <label>Ruangan</label>
    <input
        type="text"
        name="ruangan"
        class="form-control"
        placeholder="Contoh: Ruang 301"
        required
    >
</div>

                <button class="btn btn-primary">Simpan</button>

            </form>

        </div>

    </div>

</div>

@endsection
