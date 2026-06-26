@extends('layouts/contentNavbarLayout')

@section('title', 'Nilai Saya')

@section('content')

<div class="container-xxl container-p-y">

<h4 class="fw-bold mb-4">📊 Nilai Saya</h4>

<div class="card">
    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>Tugas</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Nilai Akhir</th>
                    <th>Grade</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse($nilais as $n)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $n->mata_kuliah }}</td>
                    <td>{{ $n->kelas }}</td>
                    <td>
                        <span class="badge bg-label-info">
                            {{ $n->nilai_tugas }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-label-warning">
                            {{ $n->nilai_uts }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-label-primary">
                            {{ $n->nilai_uas }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-label-dark">
                            {{ $n->nilai_akhir }}
                        </span>
                    </td>
                    <td>
                        <span class="badge
                            @if($n->grade == 'A') bg-success
                            @elseif($n->grade == 'B') bg-primary
                            @elseif($n->grade == 'C') bg-warning
                            @else bg-danger
                            @endif
                        ">
                            {{ $n->grade }}
                        </span>
                    </td>
                    <td>
                        @if($n->status == 'Lulus')
                            <span class="badge bg-label-success">Lulus</span>
                        @else
                            <span class="badge bg-label-danger">Tidak Lulus</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">
                        Belum ada nilai 😢
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>
</div>

</div>

@endsection
