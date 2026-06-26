@extends('layouts.contentNavbarLayout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        <span class="text-muted fw-light">Admin / Periode Nilai /</span> Edit Periode
    </h4>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible mb-4" role="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Form Edit Periode Nilai</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.periode-nilai.update', $periode->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Mulai Input</label>
                    <input type="datetime-local"
                           name="mulai_input"
                           class="form-control"
                           value="{{ old('mulai_input', $periode->mulai_input ? \Carbon\Carbon::parse($periode->mulai_input)->format('Y-m-d\TH:i') : '') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deadline Input</label>
                    <input type="datetime-local"
                           name="deadline_input"
                           class="form-control"
                           value="{{ old('deadline_input', $periode->deadline_input ? \Carbon\Carbon::parse($periode->deadline_input)->format('Y-m-d\TH:i') : '') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan"
                              class="form-control"
                              rows="3"
                              placeholder="Masukkan keterangan periode nilai">{{ old('keterangan', $periode->keterangan) }}</textarea>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           class="form-check-input"
                           id="is_active"
                           {{ old('is_active', $periode->is_active) ? 'checked' : '' }}>

                    <label class="form-check-label" for="is_active">
                        Aktifkan periode ini
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Simpan Perubahan
                    </button>

                    <a href="{{ route('admin.periode-nilai.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
