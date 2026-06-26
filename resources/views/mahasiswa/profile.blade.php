@extends('layouts/contentNavbarLayout')

@section('title', 'Profil Mahasiswa')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold mb-4">
        Profil Mahasiswa 👨‍🎓
    </h4>

    <div class="row">

        <!-- FOTO -->
        <div class="col-md-4">

            <div class="card">

                <div class="card-body text-center">

                    <img src="https://ui-avatars.com/api/?name=Daffa+Galih"
                         class="rounded-circle mb-3"
                         width="120">

                    <h5>Daffa Galih Pratama</h5>

                    <span class="badge bg-primary">
                        Mahasiswa Aktif
                    </span>

                </div>

            </div>

        </div>

        <!-- DATA -->
        <div class="col-md-8">

            <div class="card">

                <div class="card-header">
                    Data Mahasiswa
                </div>

                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">
                            NIM
                        </div>
                        <div class="col-md-8">
                            221011400001
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">
                            Program Studi
                        </div>
                        <div class="col-md-8">
                            Sistem Informasi
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">
                            Semester
                        </div>
                        <div class="col-md-8">
                            4
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">
                            Email
                        </div>
                        <div class="col-md-8">
                            daffa@email.com
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">
                            No HP
                        </div>
                        <div class="col-md-8">
                            081234567890
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 fw-bold">
                            Alamat
                        </div>
                        <div class="col-md-8">
                            Jakarta, Indonesia
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- STATISTIK -->
    <div class="row mt-4">

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary">3.75</h3>
                    <p>IPK</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success">24</h3>
                    <p>SKS Lulus</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-warning">90%</h3>
                    <p>Kehadiran</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-danger">5</h3>
                    <p>Tugas Selesai</p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
