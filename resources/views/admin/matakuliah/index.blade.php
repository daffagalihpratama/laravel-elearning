@extends('layouts/contentNavbarLayout')

@section('title', 'Mata Kuliah')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="fw-bold">
            Data Mata Kuliah 📚
        </h4>

        <a href="/admin/matakuliah/create"
           class="btn btn-primary">

            <i class="bx bx-plus"></i>

            Tambah Mata Kuliah

        </a>

    </div>

    <div class="card">

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Kode MK</th>

                        <th>Nama Mata Kuliah</th>

                        <th>SKS</th>

                        <th>Kode Dosen</th>

                        <th>Dosen Pengampu</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($matakuliah as $mk)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $mk->kode_mk }}
                        </td>

                        <td>
                            {{ $mk->nama_mk }}
                        </td>

                        <td>
                            {{ $mk->sks }}
                        </td>

                        <td>
                            {{ $mk->kode_dosen }}
                        </td>

                        <td>
                            {{ $mk->dosen_pengampu }}
                        </td>

                        <td>

                            <div class="d-flex gap-1">

                                <!-- EDIT -->
                                <a href="/admin/matakuliah/{{ $mk->id }}/edit"
                                   class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <!-- DELETE -->
                                <form action="/admin/matakuliah/{{ $mk->id }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus data?')">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
