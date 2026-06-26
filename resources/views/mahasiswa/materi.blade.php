@extends('layouts/contentNavbarLayout')

@section('title', 'Materi Mahasiswa')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold mb-4">
        Materi Pembelajaran 📚
    </h4>

    <div class="card">
        <div class="card-body">
            <h5> UI UX</h5>
            <p>Materi UI UX Pertemuan 1 - 15 .</p>

            <a href="{{ asset('materi/UXUIDesigner-FeriSulianta.pdf') }}"
               class="btn btn-primary">
               Download Materi
            </a>
        </div>
    </div>

</div>

@endsection
