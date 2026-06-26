@extends('layouts.contentNavbarLayout')

@section('content')
<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">Kelas Pengganti</h3>
            <a href="{{ route('dosen.kelas_pengganti.create') }}" class="btn btn-primary rounded-pill">
                <i class="bx bx-plus"></i> Ajukan Kelas Pengganti
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Pertemuan</th>
                        <th>Semester</th>
                        <th>Dosen</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Ruangan</th>
                        <th>Tanggal Ganti KP</th>
                        <th>Tanggal Pengganti</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelasPengganti as $k)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->pertemuan ?? '-' }}</td>
                        <td>Semester {{ $k->semester }}</td>
                        <td>{{ $k->dosen }}</td>
                        <td>{{ $k->hari }}</td>
                        <td>{{ $k->jam_mulai }} - {{ $k->jam_selesai }}</td>
                        <td>{{ $k->ruangan }}</td>
                        <td>
                            {{ $k->tanggal_ganti_kp ? \Carbon\Carbon::parse($k->tanggal_ganti_kp)->format('d M Y') : '-' }}
                        </td>
                        <td>
                            {{ $k->tanggal_pengganti ? \Carbon\Carbon::parse($k->tanggal_pengganti)->format('d M Y') : '-' }}
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($k->alasan, 40) }}</td>
                        <td>
                            @if($k->status == 'approved')
                                <span class="badge bg-success">
                                    <i class="bx bx-check me-1"></i> Approved
                                </span>
                            @elseif($k->status == 'rejected')
                                <span class="badge bg-danger">
                                    <i class="bx bx-x me-1"></i> Rejected
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    <i class="bx bx-time me-1"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($k->status == 'approved')
                                <a href="{{ route('dosen.kelas_pengganti.absensi', $k->id) }}" class="btn btn-sm btn-success">
                                    <i class="bx bx-list-check me-1"></i> Buka Absensi
                                </a>
                            @elseif($k->status == 'pending')
                                <form action="{{ route('dosen.kelas_pengganti.destroy', $k->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin membatalkan pengajuan kelas pengganti ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash me-1"></i> Batalkan
                                    </button>
                                </form>
                            @elseif($k->status == 'rejected')
                                <form action="{{ route('dosen.kelas_pengganti.destroy', $k->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus pengajuan yang ditolak ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="text-center text-muted py-4">
                            <i class="bx bx-calendar-x fs-3 d-block mb-2"></i>
                            Belum ada pengajuan kelas pengganti.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
