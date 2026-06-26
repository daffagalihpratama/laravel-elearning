@extends('layouts.contentNavbarLayout')

@section('title', 'Dashboard Dosen')

@section('content')

<h4 class="fw-bold py-3 mb-4">Dashboard Dosen 👨‍🏫</h4>

<div class="row">

    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <span class="fw-semibold d-block mb-1">Total Kelas</span>
                <h3 class="card-title mb-2">{{ $totalKelas }}</h3>
                <small class="text-success fw-semibold">Kelas Aktif</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <span class="fw-semibold d-block mb-1">Total Mahasiswa</span>
                <h3 class="card-title mb-2">{{ $totalMahasiswa }}</h3>
                <small class="text-info fw-semibold">Mahasiswa Terdaftar</small>
            </div>
        </div>
    </div>

</div>

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Kelas Yang Diampu</h5>
        <a href="{{ url('/dosen/kelas') }}" class="btn btn-primary btn-sm">
            <i class="bx bx-show"></i> Lihat Semua
        </a>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Kelas</th>
                    <th>Semester</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Ruangan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $k)
                <tr>
                    <td>{{ $k->nama_kelas }}</td>
                    <td>{{ $k->semester }}</td>
                    <td>{{ $k->hari }}</td>
                    <td>{{ $k->jam_mulai }} - {{ $k->jam_selesai }}</td>
                    <td>{{ $k->ruangan ?? '-' }}</td>
                    <td>
                        <span class="badge bg-label-success">Aktif</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada kelas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
