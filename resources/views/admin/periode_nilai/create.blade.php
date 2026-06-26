@extends('layouts.contentNavbarLayout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Tambah Periode Nilai</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.periode-nilai.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Mulai Input</label>
                    <input type="datetime-local" name="mulai_input"
                           class="form-control @error('mulai_input') is-invalid @enderror"
                           value="{{ old('mulai_input') }}" required>
                    @error('mulai_input')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deadline Input</label>
                    <input type="datetime-local" name="deadline_input"
                           class="form-control @error('deadline_input') is-invalid @enderror"
                           value="{{ old('deadline_input') }}" required>
                    @error('deadline_input')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('admin.periode-nilai.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
