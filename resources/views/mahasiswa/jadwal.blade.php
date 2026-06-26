@extends('layouts/contentNavbarLayout')

@section('title', 'Jadwal Kuliah')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- JUDUL -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                Jadwal Kuliah 📅
            </h4>

            <small class="text-muted">
                Jadwal perkuliahan semester aktif
            </small>

        </div>

    </div>

    <!-- CARD JADWAL -->
    <div class="row">

        <!-- ITEM -->
        <div class="col-xl-4 col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <!-- HEADER -->
                <div class="card-header bg-danger text-white text-center py-4">

                    <h5 class="mb-3 text-white fw-bold">
                        PEMROGRAMAN WEB
                    </h5>

                    <h6 class="text-white mb-0">
                        Senin • 08:00 - 10:30
                    </h6>

                </div>

                <!-- BODY -->
                <div class="card-body">

                    <ul class="list-unstyled mb-4">

                        <li class="mb-2">
                            <i class="bx bx-user"></i>
                            Dosen : Ahmad Fauzi
                        </li>

                        <li class="mb-2">
                            <i class="bx bx-book"></i>
                            Kode MK : IF201
                        </li>

                        <li class="mb-2">
                            <i class="bx bx-buildings"></i>
                            Ruangan : Lab Komputer 2
                        </li>

                        <li class="mb-2">
                            <i class="bx bx-layer"></i>
                            SKS : 3
                        </li>

                        <li class="mb-2">
                            <i class="bx bx-group"></i>
                            Kelas : TI-4A
                        </li>

                    </ul>

                    <!-- BUTTON -->
                    <div class="d-grid">

                        <a href="#"
                           class="btn btn-success">

                            <i class="bx bx-log-in-circle"></i>
                            Masuk Kelas

                        </a>

                    </div>

                </div>

            </div>

        </div>

        <!-- ITEM -->
        <div class="col-xl-4 col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header bg-primary text-white text-center py-4">

                    <h5 class="mb-3 text-white fw-bold">
                        BASIS DATA
                    </h5>

                    <h6 class="text-white mb-0">
                        Selasa • 10:00 - 12:30
                    </h6>

                </div>

                <div class="card-body">

                    <ul class="list-unstyled mb-4">

                        <li class="mb-2">
                            <i class="bx bx-user"></i>
                            Dosen : Budi Santoso
                        </li>

                        <li class="mb-2">
                            <i class="bx bx-book"></i>
                            Kode MK : IF301
                        </li>

                        <li class="mb-2">
                            <i class="bx bx-buildings"></i>
                            Ruangan : 402-C3
                        </li>

                        <li class="mb-2">
                            <i class="bx bx-layer"></i>
                            SKS : 3
                        </li>

                        <li class="mb-2">
                            <i class="bx bx-group"></i>
                            Kelas : TI-4A
                        </li>

                    </ul>

                    <div class="d-grid">

                        <a href="#"
                           class="btn btn-success">

                            <i class="bx bx-log-in-circle"></i>
                            Masuk Kelas

                        </a>

                    </div>

                </div>

            </div>

        </div>

        <!-- ITEM -->
        <div class="col-xl-4 col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-header bg-warning text-white text-center py-4">

                    <h5 class="mb-3 text-white fw-bold">
                        ARTIFICIAL INTELLIGENCE
                    </h5>

                    <h6 class="text-white mb-0">
                        Jumat • 13:00 - 15:00
                    </h6>

                </div>

                <div class="card-body">

                    <ul class="list-unstyled mb-4">

                        <li class="mb-2">
                            <i class="bx bx-user"></i>
                            Dosen : Rizky Ramadhan
                        </li>

                        <li class="mb-2">
                            <i class="bx bx-book"></i>
                            Kode MK : IF401
                        </li>

                        <li class="mb-2">
                            <i class="bx bx-buildings"></i>
                            Ruangan : Lab AI
                        </li>

                        <li class="mb-2">
                            <i class="bx bx-layer"></i>
                            SKS : 2
                        </li>

                        <li class="mb-2">
                            <i class="bx bx-group"></i>
                            Kelas : TI-4A
                        </li>

                    </ul>

                    <div class="d-grid">

                        <a href="#"
                           class="btn btn-success">

                            <i class="bx bx-log-in-circle"></i>
                            Masuk Kelas

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
