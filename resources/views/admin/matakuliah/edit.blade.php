@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Mata Kuliah')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-body">

            <h4 class="mb-4">
                Edit Mata Kuliah
            </h4>

            <form action="/admin/matakuliah/{{ $matakuliah->id }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label>Kode MK</label>

                    <input type="text"
                           name="kode_mk"
                           value="{{ $matakuliah->kode_mk }}"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>Nama Mata Kuliah</label>

                    <input type="text"
                           name="nama_mk"
                           value="{{ $matakuliah->nama_mk }}"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>SKS</label>

                    <input type="number"
                           name="sks"
                           value="{{ $matakuliah->sks }}"
                           class="form-control">

                </div>

                <div class="mb-3">

    <label>Kode Dosen</label>

    <input type="text"
           name="kode_dosen"
           value="{{ $matakuliah->kode_dosen }}"
           class="form-control">

</div>


                <div class="mb-3">

                    <label>Dosen Pengampu</label>

                    <input type="text"
                           name="dosen_pengampu"
                           value="{{ $matakuliah->dosen_pengampu }}"
                           class="form-control">

                </div>

                <button class="btn btn-primary">

                    Update

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
