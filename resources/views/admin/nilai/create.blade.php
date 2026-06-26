@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Nilai')

@section('content')

<div class="container-xxl container-p-y">

    <div class="card">

        <div class="card-header">
            <h4 class="mb-0">Tambah Nilai Mahasiswa</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('nilai.store') }}" method="POST">

                @csrf

                <!-- MAHASISWA -->
                <div class="mb-3">
                    <label class="form-label">
                        Mahasiswa
                    </label>

                    <select name="mahasiswa_id"
                            class="form-control"
                            required>

                        <option value="">
                            -- Pilih Mahasiswa --
                        </option>

                        @foreach($mahasiswas as $mhs)

                            <option value="{{ $mhs->id }}">
                                {{ $mhs->name }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <!-- KELAS -->
                <div class="mb-3">
                    <label class="form-label">
                        Kelas
                    </label>

                    <input type="text"
                           name="kelas"
                           class="form-control"
                           required>
                </div>

                <!-- MATA KULIAH -->
                <div class="mb-3">
                    <label class="form-label">
                        Mata Kuliah
                    </label>

                    <input type="text"
                           name="mata_kuliah"
                           class="form-control"
                           required>
                </div>

                <hr>

                <h5 class="mb-4">
                    Komponen Penilaian
                </h5>

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Nilai Tugas (30%)
                        </label>

                        <input type="number"
                               id="nilai_tugas"
                               name="nilai_tugas"
                               class="form-control"
                               min="0"
                               max="100"
                               required>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Nilai UTS (30%)
                        </label>

                        <input type="number"
                               id="nilai_uts"
                               name="nilai_uts"
                               class="form-control"
                               min="0"
                               max="100"
                               required>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Nilai UAS (40%)
                        </label>

                        <input type="number"
                               id="nilai_uas"
                               name="nilai_uas"
                               class="form-control"
                               min="0"
                               max="100"
                               required>

                    </div>

                </div>

                <!-- PREVIEW -->
                <div class="row mt-3">

                    <div class="col-md-6">

                        <div class="card border-primary">

                            <div class="card-body text-center">

                                <h6 class="text-primary">
                                    Nilai Akhir
                                </h6>

                                <h1 id="nilai_akhir_preview">
                                    0
                                </h1>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="card border-success">

                            <div class="card-body text-center">

                                <h6 class="text-success">
                                    Grade
                                </h6>

                                <h1 id="grade_preview">
                                    -
                                </h1>

                            </div>

                        </div>

                    </div>

                </div>

                <hr>

                <!-- STATUS -->
                <div class="mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status"
                            class="form-control">

                        <option value="Lulus">
                            Lulus
                        </option>

                        <option value="Tidak Lulus">
                            Tidak Lulus
                        </option>

                    </select>

                </div>

                <div class="mt-4">

                    <button type="submit"
                            class="btn btn-primary">

                        Simpan Nilai

                    </button>

                    <a href="{{ route('nilai.index') }}"
                       class="btn btn-secondary">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

function hitungNilai()
{
    let tugas =
        parseFloat(document.getElementById('nilai_tugas').value) || 0;

    let uts =
        parseFloat(document.getElementById('nilai_uts').value) || 0;

    let uas =
        parseFloat(document.getElementById('nilai_uas').value) || 0;

    let akhir =
        (tugas * 0.30) +
        (uts * 0.30) +
        (uas * 0.40);

    document.getElementById('nilai_akhir_preview')
        .innerHTML = akhir.toFixed(2);

    let grade = 'E';

    if (akhir >= 85)
    {
        grade = 'A';
    }
    else if (akhir >= 75)
    {
        grade = 'B';
    }
    else if (akhir >= 65)
    {
        grade = 'C';
    }
    else if (akhir >= 50)
    {
        grade = 'D';
    }

    document.getElementById('grade_preview')
        .innerHTML = grade;
}

document.getElementById('nilai_tugas')
    .addEventListener('keyup', hitungNilai);

document.getElementById('nilai_uts')
    .addEventListener('keyup', hitungNilai);

document.getElementById('nilai_uas')
    .addEventListener('keyup', hitungNilai);

</script>

@endsection
