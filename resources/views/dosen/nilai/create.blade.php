@extends('layouts.contentNavbarLayout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Nilai /</span> Tambah Nilai
        </h4>
        <a href="{{ route('dosen.nilai') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back me-1"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('dosen.nilai.store') }}" method="POST">
                @csrf

                {{-- Mahasiswa --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Mahasiswa</label>
                    <select name="mahasiswa_id" class="form-select @error('mahasiswa_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach ($mahasiswas as $mhs)
                            <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                {{ $mhs->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('mahasiswa_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas') }}"
                           class="form-control @error('kelas') is-invalid @enderror"
                           placeholder="Contoh: 19.1A.29" required>
                    @error('kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mata Kuliah --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Mata Kuliah</label>
                    <input type="text" name="mata_kuliah" value="{{ old('mata_kuliah') }}"
                           class="form-control @error('mata_kuliah') is-invalid @enderror"
                           placeholder="Contoh: UI/UX Design" required>
                    @error('mata_kuliah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nilai --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Nilai Tugas (30%)</label>
                        <input type="number" name="nilai_tugas" value="{{ old('nilai_tugas') }}"
                               class="form-control @error('nilai_tugas') is-invalid @enderror"
                               min="0" max="100" placeholder="0-100" required>
                        @error('nilai_tugas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Nilai UTS (30%)</label>
                        <input type="number" name="nilai_uts" value="{{ old('nilai_uts') }}"
                               class="form-control @error('nilai_uts') is-invalid @enderror"
                               min="0" max="100" placeholder="0-100" required>
                        @error('nilai_uts')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Nilai UAS (40%)</label>
                        <input type="number" name="nilai_uas" value="{{ old('nilai_uas') }}"
                               class="form-control @error('nilai_uas') is-invalid @enderror"
                               min="0" max="100" placeholder="0-100" required>
                        @error('nilai_uas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Info otomatis --}}
                <div class="alert alert-info mb-3">
                    <i class="bx bx-info-circle me-1"></i>
                    <strong>Nilai Akhir & Grade</strong> dihitung otomatis oleh sistem.
                    <br>Formula: <code>(Tugas × 30%) + (UTS × 30%) + (UAS × 40%)</code>
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Lulus" {{ old('status') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                        <option value="Tidak Lulus" {{ old('status') == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Simpan Nilai
                    </button>
                    <a href="{{ route('dosen.nilai') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
