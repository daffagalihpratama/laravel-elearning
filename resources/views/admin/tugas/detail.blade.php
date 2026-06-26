@extends('layouts/contentNavbarLayout')

@section('title', 'Admin - Detail Tugas')

@section('content')

<div class="container-xxl container-p-y">

    <h4 class="fw-bold mb-3">📄 Detail Pengumpulan (Read Only)</h4>

    <div class="card mb-4">
        <div class="card-body">

            <h5>{{ $tugas->judul }}</h5>
            <p>{{ $tugas->deskripsi }}</p>

            <hr>

            <p><b>Kelas:</b> {{ $tugas->kelas->nama_kelas ?? '-' }}</p>
            <p><b>Dosen:</b> {{ $tugas->dosen->name ?? '-' }}</p>
            <p><b>Deadline:</b> {{ $tugas->deadline }}</p>

        </div>
    </div>

    <h5>📥 Pengumpulan Mahasiswa</h5>

    @forelse($tugas->pengumpulans as $p)

        <div class="card mb-2">
            <div class="card-body">

                <p><b>Nama:</b> {{ $p->mahasiswa->name }}</p>

                <p>
                    <b>Jawaban:</b>
                    <a href="{{ $p->link_jawaban }}" target="_blank">
                        Lihat Link
                    </a>
                </p>

                <p>
                    <b>Nilai:</b> {{ $p->nilai ?? 'Belum dinilai' }}
                </p>

            </div>
        </div>

    @empty
        <p class="text-muted">Belum ada pengumpulan</p>
    @endforelse

</div>

@endsection
