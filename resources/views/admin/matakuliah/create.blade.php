@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Mata Kuliah')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-body">

            <h4 class="mb-4">
                Tambah Mata Kuliah
            </h4>

            <form action="/admin/matakuliah"
                  method="POST">

                @csrf

                <div class="mb-3">

                    <label>Kode MK</label>

                    <input type="text"
                           name="kode_mk"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>Nama Mata Kuliah</label>

                    <input type="text"
                           name="nama_mk"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>SKS</label>

                    <input type="number"
                           name="sks"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

    <label>Kode Dosen</label>

    <input type="text"
           name="kode_dosen"
           class="form-control"
           required>

</div>

                <div class="mb-3">

                    <label>Dosen Pengampu</label>

                    <input type="text"
                           name="dosen_pengampu"
                           class="form-control"
                           required>

                </div>

                <button class="btn btn-primary">

                    Simpan

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
