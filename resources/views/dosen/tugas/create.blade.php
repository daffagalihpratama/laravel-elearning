@extends('layouts/contentNavbarLayout')

@section('title', 'Buat Tugas')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">📝 Buat Tugas</h4>
        <a href="{{ route('dosen.tugas') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('dosen.tugas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <select name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
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
                           value="{{ old('judul') }}"
                           placeholder="Masukkan judul tugas">
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                              class="form-control @error('deskripsi') is-invalid @enderror"
                              placeholder="Masukkan deskripsi tugas">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="datetime-local" name="deadline"
                           class="form-control @error('deadline') is-invalid @enderror"
                           value="{{ old('deadline') }}">
                    @error('deadline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Lampiran File</label>
                    <input type="file" name="lampiran"
                           class="form-control @error('lampiran') is-invalid @enderror">
                    <small class="text-muted">
                        Format: pdf, doc, docx, xls, xlsx, ppt, pptx, zip, jpg, jpeg, png. Maksimal 5MB.
                    </small>
                    @error('lampiran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">💾 Simpan Tugas</button>
            </form>
        </div>
    </div>
</div>
@endsection
