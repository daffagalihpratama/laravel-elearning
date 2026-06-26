@extends('layouts.contentNavbarLayout')

@section('content')
<div class="container">
    <h3 class="mb-4">Manajemen Periode Nilai</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.periode-nilai.create') }}" class="btn btn-primary">
            Tambah Periode
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mulai Input</th>
                        <th>Deadline Input</th>
                        <th>Keterangan</th>
                        <th>Status Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($periodes as $key => $periode)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>
                                @if($periode->mulai_input)
                                    {{ \Carbon\Carbon::parse($periode->mulai_input)->format('d-m-Y H:i') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if($periode->deadline_input)
                                    {{ \Carbon\Carbon::parse($periode->deadline_input)->format('d-m-Y H:i') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ $periode->keterangan ?? '-' }}</td>

                            <td>
                                @if($periode->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.periode-nilai.edit', $periode->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('admin.periode-nilai.destroy', $periode->id) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus periode ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Belum ada data periode nilai
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
