@extends('layouts/contentNavbarLayout')

@section('title', 'Absensi Saya')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold mb-4">
        Kehadiran Saya 📅
    </h4>

    @foreach($kelas as $item)

    <div class="card shadow-sm mb-4">

        <div class="card-header bg-primary text-white">
            {{ $item->mataKuliah->nama_mk ?? 'Mata Kuliah' }}

            @if(!empty($item->kode_kp))
                - {{ $item->kode_kp }}
            @endif
        </div>

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <h5>
                        Kuliah ({{ $item->mataKuliah->sks ?? 0 }} SKS)
                    </h5>

                    @if(!empty($item->kode_kp))
                        <small class="text-muted">
                            Termasuk kelas utama dan kelas pengganti
                        </small>
                    @else
                        <small class="text-muted">
                            Kelas utama
                        </small>
                    @endif

                    <div class="row mt-3">

                        <div class="col-3">
                            <h4>{{ $item->hadir }}</h4>
                            <small>Hadir</small>
                        </div>

                        <div class="col-3">
                            <h4 class="text-danger">
                                {{ $item->tidak_hadir }}
                            </h4>
                            <small>Tidak Hadir</small>
                        </div>

                    </div>

                </div>

                <div class="col-md-4 text-center">

                    <div class="circle-success">
                        {{ $item->persentase }}%
                    </div>

                </div>

            </div>

        </div>

    </div>

    @endforeach

</div>

<style>

.circle-success{
    width:90px;
    height:90px;
    border-radius:50%;
    border:8px solid #28c76f;

    display:flex;
    justify-content:center;
    align-items:center;

    font-weight:bold;
    font-size:18px;

    margin:auto;
}

</style>

@endsection
