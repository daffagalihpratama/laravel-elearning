@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Nilai')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold mb-4">Edit Nilai ✏️</h4>

    <div class="card p-4">

        <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- MAHASISWA -->
            <div class="mb-3">
                <label class="form-label">Mahasiswa</label>
                <select name="mahasiswa_id" class="form-control" required>
                    <option value="">-- Pilih Mahasiswa --</option>
                    @foreach($mahasiswas as $mhs)
                        <option value="{{ $mhs->id }}"
                            {{ $nilai->mahasiswa_id == $mhs->id ? 'selected' : '' }}>
                            {{ $mhs->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- KELAS -->
            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control"
                       value="{{ old('kelas', $nilai->kelas) }}" required>
            </div>

            <!-- MATA KULIAH -->
            <div class="mb-3">
                <label class="form-label">Mata Kuliah</label>
                <input type="text" name="mata_kuliah" class="form-control"
                       value="{{ old('mata_kuliah', $nilai->mata_kuliah) }}" required>
            </div>

            <!-- NILAI TUGAS -->
            <div class="mb-3">
                <label class="form-label">Nilai Tugas</label>
                <input type="number" name="nilai_tugas" class="form-control" min="0" max="100"
                       value="{{ old('nilai_tugas', $nilai->nilai_tugas) }}" required>
            </div>

            <!-- NILAI UTS -->
            <div class="mb-3">
                <label class="form-label">Nilai UTS</label>
                <input type="number" name="nilai_uts" class="form-control" min="0" max="100"
                       value="{{ old('nilai_uts', $nilai->nilai_uts) }}" required>
            </div>

            <!-- NILAI UAS -->
            <div class="mb-3">
                <label class="form-label">Nilai UAS</label>
                <input type="number" name="nilai_uas" class="form-control" min="0" max="100"
                       value="{{ old('nilai_uas', $nilai->nilai_uas) }}" required>
            </div>

            <!-- STATUS -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="Lulus"
                        {{ old('status', $nilai->status) == 'Lulus' ? 'selected' : '' }}>
                        Lulus
                    </option>
                    <option value="Tidak Lulus"
                        {{ old('status', $nilai->status) == 'Tidak Lulus' ? 'selected' : '' }}>
                        Tidak Lulus
                    </option>
                </select>
            </div>

            <!-- BUTTON -->
            <button class="btn btn-primary">Update</button>

            <a href="{{ url('/admin/nilai') }}" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection
