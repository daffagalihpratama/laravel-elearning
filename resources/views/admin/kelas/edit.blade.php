@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Kelas')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-body">

            <h4 class="mb-4">Edit Kelas</h4>

            <form action="/admin/kelas/{{ $kelas->id }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Mata Kuliah</label>
                    <select name="mata_kuliah_id" class="form-control">
                        <option value="">-- Pilih Mata Kuliah --</option>
                        @foreach($matakuliah as $mk)
                            <option value="{{ $mk->id }}"
    {{ $kelas->mata_kuliah_id == $mk->id ? 'selected' : '' }}>
    {{ $mk->nama_mk }}
</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Nama Kelas</label>
                    <input type="text" name="nama_kelas"
                           value="{{ $kelas->nama_kelas }}"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Semester</label>
                    <input type="text" name="semester"
                           value="{{ $kelas->semester }}"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Dosen</label>
                    <input type="text" name="dosen"
                           value="{{ $kelas->dosen }}"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Hari</label>
                    <select name="hari" class="form-control">
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                            <option value="{{ $hari }}"
                                {{ $kelas->hari == $hari ? 'selected' : '' }}>
                                {{ $hari }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Jam Mulai</label>
                    <input type="time" name="jam_mulai"
                           value="{{ $kelas->jam_mulai }}"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Jam Selesai</label>
                    <input type="time" name="jam_selesai"
                           value="{{ $kelas->jam_selesai }}"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Ruangan</label>
                    <input type="text" name="ruangan"
                           value="{{ $kelas->ruangan }}"
                           class="form-control">
                </div>

                <button class="btn btn-primary">Update</button>

            </form>

        </div>

    </div>

</div>

@endsection
