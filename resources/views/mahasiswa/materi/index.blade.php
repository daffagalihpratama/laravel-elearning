@extends('layouts/contentNavbarLayout')

@section('title', 'Materi Mahasiswa')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- JUDUL -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="fw-bold">
            Materi Pembelajaran 📚
        </h4>

        <div>
            <input type="text"
                   class="form-control"
                   placeholder="Cari materi...">
        </div>

    </div>

    <!-- CARD MATERI -->
    <div class="row">

        <!-- CARD 1 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">

                <div class="card-header d-flex align-items-center justify-content-between">
                    <span class="badge bg-label-primary">Pemrograman Web</span>
                    <small class="text-muted">10 Mei 2026</small>
                </div>

                <div class="card-body">

                    <h5 class="card-title">Laravel CRUD</h5>

                    <p class="card-text">
                        Materi tentang pembuatan CRUD menggunakan Laravel 12
                        mulai dari migration, model, controller hingga blade.
                    </p>

                    <div class="mb-3">
                        <small class="text-muted">
                            File: laravel-crud.pdf
                        </small>
                    </div>

                    <div class="d-flex gap-2">

                        <!-- ✅ FIX DOWNLOAD -->
                        <a href="{{ asset('uploads/materi/laravel-crud.pdf') }}"
                           class="btn btn-primary btn-sm"
                           download>
                           <i class="bx bx-download"></i> Download
                        </a>

                        <button class="btn btn-outline-secondary btn-sm">
                            Detail
                        </button>

                    </div>

                </div>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">

                <div class="card-header d-flex align-items-center justify-content-between">
                    <span class="badge bg-label-success">Basis Data</span>
                    <small class="text-muted">11 Mei 2026</small>
                </div>

                <div class="card-body">

                    <h5 class="card-title">Normalisasi Database</h5>

                    <p class="card-text">
                        Pembahasan mengenai normalisasi database dari 1NF,
                        2NF, hingga 3NF beserta contoh tabel.
                    </p>

                    <div class="mb-3">
                        <small class="text-muted">
                            File: normalisasi.pdf
                        </small>
                    </div>

                    <div class="d-flex gap-2">

                        <a href="{{ asset('uploads/materi/normalisasi.pdf') }}"
                           class="btn btn-success btn-sm"
                           download>
                           <i class="bx bx-download"></i> Download
                        </a>

                        <button class="btn btn-outline-secondary btn-sm">
                            Detail
                        </button>

                    </div>

                </div>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">

                <div class="card-header d-flex align-items-center justify-content-between">
                    <span class="badge bg-label-warning">Artificial Intelligence</span>
                    <small class="text-muted">12 Mei 2026</small>
                </div>

                <div class="card-body">

                    <h5 class="card-title">Machine Learning Dasar</h5>

                    <p class="card-text">
                        Pengantar machine learning, supervised learning,
                        unsupervised learning, dan implementasinya.
                    </p>

                    <div class="mb-3">
                        <small class="text-muted">
                            File: machine-learning.pdf
                        </small>
                    </div>

                    <div class="d-flex gap-2">

                        <a href="{{ asset('uploads/materi/MLBOOK.pdf') }}"
                           class="btn btn-warning btn-sm"
                           download>
                           <i class="bx bx-download"></i> Download
                        </a>

                        <button class="btn btn-outline-secondary btn-sm">
                            Detail
                        </button>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
