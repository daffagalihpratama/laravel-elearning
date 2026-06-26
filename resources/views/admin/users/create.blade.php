@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah User')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-body">

            <h4 class="mb-4">Tambah User</h4>

            <form action="/admin/users" method="POST">

                @csrf

                <div class="mb-3">
                    <label>Nama</label>

                    <input type="text"
                           name="name"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Email</label>

                    <input type="email"
                           name="email"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Password</label>

                    <input type="password"
                           name="password"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label>Role</label>

                    <select name="role" class="form-control">

                        <option value="admin">Admin</option>

                        <option value="dosen">Dosen</option>

                        <option value="mahasiswa">Mahasiswa</option>

                    </select>
                </div>

                <button class="btn btn-primary">
                    Simpan
                </button>

            </form>

        </div>

    </div>

</div>

@endsection
