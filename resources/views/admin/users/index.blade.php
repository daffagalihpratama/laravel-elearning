@extends('layouts/contentNavbarLayout')

@section('title', 'Kelola User')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                Kelola User 👥
            </h4>

            <p class="text-muted mb-0">
                Management data user E-Learning
            </p>

        </div>

        <!-- BUTTON TAMBAH -->
        <a href="/admin/users/create"
           class="btn btn-primary">

            <i class="bx bx-plus"></i>

            Tambah User

        </a>

    </div>

    <!-- CARD -->
    <div class="card">

        <!-- HEADER CARD -->
        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Data User
            </h5>

            <!-- SEARCH -->
            <div style="width: 250px;">

                <input type="text"
                       class="form-control"
                       placeholder="Search user...">

            </div>

        </div>

        <!-- TABLE -->
        <div class="table-responsive text-nowrap">

            <table class="table table-hover">

                <thead class="table-light">

                    <tr>

                        <th>No</th>

                        <th>Nama</th>

                        <th>Email</th>

                        <th>Role</th>

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody class="table-border-bottom-0">

                    @forelse ($users as $user)

                    <tr>

                        <!-- NOMOR -->
                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <!-- NAMA -->
                        <td>

                            <strong>
                                {{ $user->name }}
                            </strong>

                        </td>

                        <!-- EMAIL -->
                        <td>

                            {{ $user->email }}

                        </td>

                        <!-- ROLE -->
                        <td>

                            @if ($user->role == 'admin')

                                <span class="badge bg-label-primary">
                                    Admin
                                </span>

                            @elseif ($user->role == 'dosen')

                                <span class="badge bg-label-warning">
                                    Dosen
                                </span>

                            @else

                                <span class="badge bg-label-info">
                                    Mahasiswa
                                </span>

                            @endif

                        </td>

                        <!-- STATUS -->
                        <td>

                            <span class="badge bg-label-success">
                                Aktif
                            </span>

                        </td>

                        <!-- AKSI -->
                        <td>

                            <div class="d-flex gap-1">

                                <!-- EDIT -->
                                <a href="/admin/users/{{ $user->id }}/edit"
                                   class="btn btn-sm btn-warning">

                                    <i class="bx bx-edit-alt"></i>

                                </a>

                                <!-- DELETE -->
                                <form action="/admin/users/{{ $user->id }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus user?')">

                                        <i class="bx bx-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
                            class="text-center py-4">

                            Tidak ada data user

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
