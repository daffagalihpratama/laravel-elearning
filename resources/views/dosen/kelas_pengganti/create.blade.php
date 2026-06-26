@extends('layouts.contentNavbarLayout')

@section('content')
<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-2">
                <span style="font-size:1.5rem;">🔄</span>
                <h3 class="fw-bold mb-0">Ajukan Kelas Pengganti</h3>
            </div>
            <a href="{{ route('dosen.kelas_pengganti') }}" class="btn btn-secondary px-4">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dosen.kelas_pengganti.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="kelas_id" class="form-label fw-semibold">Pilih Kelas</label>
                <select
                    name="kelas_id"
                    id="kelas_id"
                    class="form-select @error('kelas_id') is-invalid @enderror"
                    required
                >
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} - {{ $k->mataKuliah->nama_mk ?? '-' }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="pertemuan" class="form-label fw-semibold">Pertemuan</label>
                <select
                    name="pertemuan"
                    id="pertemuan"
                    class="form-select @error('pertemuan') is-invalid @enderror"
                    required
                >
                    <option value="">-- Pilih Pertemuan --</option>
                    @for($i = 1; $i <= 16; $i++)
                        <option value="{{ $i }}" {{ old('pertemuan') == $i ? 'selected' : '' }}>
                            Pertemuan {{ $i }}
                        </option>
                    @endfor
                </select>
                @error('pertemuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="dosen" class="form-label fw-semibold">Dosen</label>
                <input
                    type="text"
                    id="dosen"
                    class="form-control bg-light"
                    value="{{ auth()->user()->name }}"
                    readonly
                >
                <small class="text-muted">Terisi otomatis dari akun yang sedang login.</small>
            </div>

            <div class="mb-3">
                <label for="hari" class="form-label fw-semibold">Hari</label>
                <select
                    name="hari"
                    id="hari"
                    class="form-select @error('hari') is-invalid @enderror"
                    required
                >
                    <option value="">-- Pilih Hari --</option>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                        <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>
                            {{ $hari }}
                        </option>
                    @endforeach
                </select>
                @error('hari')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jam_mulai" class="form-label fw-semibold">Jam Mulai</label>
                    <input
                        type="time"
                        name="jam_mulai"
                        id="jam_mulai"
                        class="form-control @error('jam_mulai') is-invalid @enderror"
                        value="{{ old('jam_mulai') }}"
                        required
                    >
                    @error('jam_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jam_selesai" class="form-label fw-semibold">Jam Selesai</label>
                    <input
                        type="time"
                        name="jam_selesai"
                        id="jam_selesai"
                        class="form-control @error('jam_selesai') is-invalid @enderror"
                        value="{{ old('jam_selesai') }}"
                        required
                    >
                    @error('jam_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="ruangan" class="form-label fw-semibold">Ruangan</label>
                <input
                    type="text"
                    name="ruangan"
                    id="ruangan"
                    class="form-control @error('ruangan') is-invalid @enderror"
                    placeholder="Contoh: Lab Komputer 2"
                    value="{{ old('ruangan') }}"
                    required
                >
                @error('ruangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_ganti_kp" class="form-label fw-semibold">Tanggal Ganti KP</label>
                <input
                    type="date"
                    name="tanggal_ganti_kp"
                    id="tanggal_ganti_kp"
                    class="form-control @error('tanggal_ganti_kp') is-invalid @enderror"
                    value="{{ old('tanggal_ganti_kp') }}"
                    required
                >
                <small class="text-muted">Isi dengan tanggal kelas awal yang ingin diganti.</small>
                @error('tanggal_ganti_kp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_pengganti" class="form-label fw-semibold">Tanggal Pengganti</label>
                <input
                    type="date"
                    name="tanggal_pengganti"
                    id="tanggal_pengganti"
                    class="form-control @error('tanggal_pengganti') is-invalid @enderror"
                    value="{{ old('tanggal_pengganti') }}"
                    required
                >
                <small class="text-muted">Isi dengan tanggal pelaksanaan kelas pengganti.</small>
                @error('tanggal_pengganti')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="alasan" class="form-label fw-semibold">Alasan</label>
                <textarea
                    name="alasan"
                    id="alasan"
                    class="form-control @error('alasan') is-invalid @enderror"
                    rows="3"
                    placeholder="Jelaskan alasan pengajuan kelas pengganti..."
                    required
                >{{ old('alasan') }}</textarea>
                @error('alasan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bx bx-send me-1"></i> Ajukan
                </button>
                <a href="{{ route('dosen.kelas_pengganti') }}" class="btn btn-secondary px-4">
                    <i class="bx bx-x me-1"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
