@extends('layouts.contentNavbarLayout')

@section('title', 'Data Mahasiswa')

@section('content')

<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">👨‍🎓 Data Mahasiswa</h3>
        </div>

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswas as $m)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $m->name }}</td>
                    <td>{{ $m->email }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Belum ada mahasiswa</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection
