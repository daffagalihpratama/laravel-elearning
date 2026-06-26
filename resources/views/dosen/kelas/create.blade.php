@extends('layouts.contentNavbarLayout')

@section('content')

<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Tambah Kelas</h4>
    </div>

    <div class="card-body">

        <form action="{{ url('/dosen/kelas/store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Kelas</label>
                <input type="text"
                       name="nama_kelas"
                       class="form-control"
                       placeholder="Contoh: TI-4A"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mata Kuliah</label>

                <select name="mata_kuliah_id"
                        class="form-control"
                        required>

                    <option value="">
                        -- Pilih Mata Kuliah --
                    </option>

                    @foreach($matakuliah as $mk)
                        <option value="{{ $mk->id }}">
                            {{ $mk->nama_mk }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Semester</label>
                <input type="number"
                       name="semester"
                       class="form-control"
                       placeholder="Contoh: 4"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Wali Kelas</label>
                <input type="text"
                       name="wali_kelas"
                       class="form-control"
                       placeholder="Nama Dosen"
                       required>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ url('/dosen/kelas') }}" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection
