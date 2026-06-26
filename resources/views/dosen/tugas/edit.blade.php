@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Tugas')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">✏️ Edit Tugas</h4>
        <a href="{{ route('dosen.tugas') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('dosen.tugas.update', $tugas->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <select name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ $tugas->kelas_id == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Tugas</label>
                    <input type="text" name="judul"
                           class="form-control @error('judul') is-invalid @enderror"
                           value="{{ old('judul', $tugas->judul) }}">
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                              class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="datetime-local" name="deadline"
                           class="form-control @error('deadline') is-invalid @enderror"
                           value="{{ old('deadline', \Carbon\Carbon::parse($tugas->deadline)->format('Y-m-d\TH:i')) }}">
                    @error('deadline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning">💾 Update Tugas</button>
            </form>

        </div>
    </div>
</div>
@endsection
