@extends('layouts.contentNavbarLayout')

@section('content')
<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body">

        <h3 class="fw-bold mb-4">🔄 Pengajuan Kelas Pengganti</h3>

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
                        <th>Kelas Asal</th>
                        <th>Nama Kelas</th>
                        <th>Hari</th>
                        <th>Jam</th>
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
                        <td>{{ $k->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->hari }}</td>
                        <td>{{ $k->jam_mulai }} - {{ $k->jam_selesai }}</td>

                        <td>
                            {{ $k->tanggal_ganti_kp ? \Carbon\Carbon::parse($k->tanggal_ganti_kp)->format('d M Y') : '-' }}
                        </td>

                        <td>
                            {{ $k->tanggal_pengganti ? \Carbon\Carbon::parse($k->tanggal_pengganti)->format('d M Y') : '-' }}
                        </td>

                        <td>{{ $k->alasan }}</td>

                        <td>
                            @if($k->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($k->status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>

                        <td>
                            @if($k->status == 'pending')
                                <form action="{{ route('admin.kelas_pengganti.approve', $k->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success mb-1">
                                        ✅ Approve
                                    </button>
                                </form>

                                <form action="{{ route('admin.kelas_pengganti.reject', $k->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger mb-1">
                                        ❌ Reject
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.kelas_pengganti.destroy', $k->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data kelas pengganti ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-dark mb-1">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
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
