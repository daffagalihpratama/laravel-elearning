@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Materi')

@section('content')

<div class="card">

    <div class="card-header">

        <h4>Tambah Materi</h4>

    </div>

    <div class="card-body">

        <form action="{{ route('dosen.materi.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="mb-3">

                <label>Kelas</label>

                <select name="kelas_id"
                        class="form-control">

                    @foreach($kelas as $k)

                    <option value="{{ $k->id }}">
                        {{ $k->nama_kelas }}
                    </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-3">

                <label>Pertemuan</label>

                <input type="number"
                       name="pertemuan"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Judul Materi</label>

                <input type="text"
                       name="judul"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Deskripsi</label>

                <textarea name="deskripsi"
                          class="form-control"></textarea>

            </div>

            <div class="mb-3">

                <label>Upload File</label>

                <input type="file"
                       name="file"
                       class="form-control">

            </div>

            <button type="submit"
                    class="btn btn-primary">

                Simpan

            </button>

        </form>

    </div>

</div>

@endsection
