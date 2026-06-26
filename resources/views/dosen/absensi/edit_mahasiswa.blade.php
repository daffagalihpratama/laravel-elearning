@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Absensi Mahasiswa')

@section('content')

<div class="row">
    <div class="col-12">

        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Edit Absensi Mahasiswa</h5>
                    <small class="text-muted">
                        Kelola data kehadiran mahasiswa pada kelas ini
                    </small>
                </div>

                <a href="{{ route('dosen.absensi.detail', $kelas->id) }}" class="btn btn-label-secondary">
                    <i class="bx bx-arrow-back me-1"></i>
                    Kembali
                </a>
            </div>

            <div class="card-body">

                {{-- ALERT SUKSES --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- ALERT ERROR VALIDASI --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong>Gagal menyimpan!</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- INFO MAHASISWA DAN KELAS --}}
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="border rounded p-3 h-100">
                            <small class="text-muted d-block mb-1">Nama Mahasiswa</small>
                            <h6 class="mb-0">{{ $mahasiswa->name ?? '-' }}</h6>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100">
                            <small class="text-muted d-block mb-1">Kelas</small>
                            <h6 class="mb-0">
                                {{ $kelas->nama_kelas ?? $kelas->nama ?? '-' }}
                            </h6>
                        </div>
                    </div>
                </div>

                {{-- FORM UPDATE ABSENSI --}}
                <form action="{{ route('dosen.absensi.update-mahasiswa', [$kelas->id, $mahasiswa->id]) }}" method="POST">
                    @csrf

                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="80">No</th>
                                    <th>Pertemuan</th>
                                    <th>Status Kehadiran</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($absensi as $index => $item)
                                    @php
                                        $selectedStatus = old('status.' . $item->id, $item->status);

                                        $badgeClass = match($selectedStatus) {
                                            'Hadir' => 'bg-label-success',
                                            'Izin'  => 'bg-label-warning',
                                            'Sakit' => 'bg-label-info',
                                            'Alfa'  => 'bg-label-danger',
                                            default => 'bg-label-secondary'
                                        };
                                    @endphp

                                    <tr>
                                        <td>{{ $index + 1 }}</td>

                                        <td>
                                            <span class="badge bg-label-primary">
                                                Pertemuan {{ $item->pertemuan_ke }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <select name="status[{{ $item->id }}]" class="form-select">
                                                    <option value="Hadir" {{ $selectedStatus == 'Hadir' ? 'selected' : '' }}>
                                                        Hadir
                                                    </option>

                                                    <option value="Izin" {{ $selectedStatus == 'Izin' ? 'selected' : '' }}>
                                                        Izin
                                                    </option>

                                                    <option value="Sakit" {{ $selectedStatus == 'Sakit' ? 'selected' : '' }}>
                                                        Sakit
                                                    </option>

                                                    <option value="Alfa" {{ $selectedStatus == 'Alfa' ? 'selected' : '' }}>
                                                        Alfa
                                                    </option>
                                                </select>

                                                <span class="badge {{ $badgeClass }}">
                                                    {{ $selectedStatus }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            Belum ada data absensi untuk mahasiswa ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('dosen.absensi.detail', $kelas->id) }}" class="btn btn-label-secondary">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection
