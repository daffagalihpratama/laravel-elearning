@extends('layouts/contentNavbarLayout')

@section('title', 'Edit User')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-body">

            <h4 class="mb-4">Edit User</h4>

            <form action="/admin/users/{{ $user->id }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label>Nama</label>

                    <input type="text"
                           name="name"
                           value="{{ $user->name }}"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>Email</label>

                    <input type="email"
                           name="email"
                           value="{{ $user->email }}"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>Role</label>

                    <select name="role" class="form-control">

                        <option value="admin"
                            {{ $user->role == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="dosen"
                            {{ $user->role == 'dosen' ? 'selected' : '' }}>
                            Dosen
                        </option>

                        <option value="mahasiswa"
                            {{ $user->role == 'mahasiswa' ? 'selected' : '' }}>
                            Mahasiswa
                        </option>

                    </select>

                </div>

                <button class="btn btn-primary">
                    Update
                </button>

            </form>

        </div>

    </div>

</div>

@endsection
