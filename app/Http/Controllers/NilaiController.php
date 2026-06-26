<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\User;
use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\PeriodeNilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    // =========================
    // HELPER PERIODE NILAI
    // =========================
    private function getPeriodeNilaiAktif()
    {
        return PeriodeNilai::where('is_active', true)
            ->latest()
            ->first();
    }

    private function periodeNilaiMasihDibuka()
    {
        $periode = $this->getPeriodeNilaiAktif();

        if (!$periode) {
            return false;
        }

        return now()->between($periode->mulai_input, $periode->deadline_input);
    }

    // =========================
    // 🛡 ADMIN (CRUD)
    // =========================
    public function index()
    {
        $nilais = Nilai::with('mahasiswa')->get();
        return view('admin.nilai.index', compact('nilais'));
    }

    public function create()
    {
        $mahasiswas = User::where('role', 'mahasiswa')->get();
        return view('admin.nilai.create', compact('mahasiswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'kelas'        => 'required|string|max:255',
            'mata_kuliah'  => 'required|string|max:255',
            'nilai_tugas'  => 'required|numeric|min:0|max:100',
            'nilai_uts'    => 'required|numeric|min:0|max:100',
            'nilai_uas'    => 'required|numeric|min:0|max:100',
            'status'       => 'required|in:Lulus,Tidak Lulus',
        ]);

        $nilaiAkhir = ($request->nilai_tugas * 0.30)
                    + ($request->nilai_uts * 0.30)
                    + ($request->nilai_uas * 0.40);

        $grade = match (true) {
            $nilaiAkhir >= 85 => 'A',
            $nilaiAkhir >= 75 => 'B',
            $nilaiAkhir >= 65 => 'C',
            $nilaiAkhir >= 50 => 'D',
            default => 'E',
        };

        $mahasiswa = User::findOrFail($request->mahasiswa_id);

        Nilai::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'mahasiswa'    => $mahasiswa->name,
            'kelas'        => $request->kelas,
            'mata_kuliah'  => $request->mata_kuliah,
            'nilai_tugas'  => $request->nilai_tugas,
            'nilai_uts'    => $request->nilai_uts,
            'nilai_uas'    => $request->nilai_uas,
            'nilai_akhir'  => $nilaiAkhir,
            'grade'        => $grade,
            'status'       => $request->status,
        ]);

        return redirect('/admin/nilai')->with('success', 'Data nilai berhasil ditambahkan');
    }

    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $mahasiswas = User::where('role', 'mahasiswa')->get();

        return view('admin.nilai.edit', compact('nilai', 'mahasiswas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'kelas'        => 'required|string|max:255',
            'mata_kuliah'  => 'required|string|max:255',
            'nilai_tugas'  => 'required|numeric|min:0|max:100',
            'nilai_uts'    => 'required|numeric|min:0|max:100',
            'nilai_uas'    => 'required|numeric|min:0|max:100',
            'status'       => 'required|in:Lulus,Tidak Lulus',
        ]);

        $nilaiAkhir = ($request->nilai_tugas * 0.30)
                    + ($request->nilai_uts * 0.30)
                    + ($request->nilai_uas * 0.40);

        $grade = match (true) {
            $nilaiAkhir >= 85 => 'A',
            $nilaiAkhir >= 75 => 'B',
            $nilaiAkhir >= 65 => 'C',
            $nilaiAkhir >= 50 => 'D',
            default => 'E',
        };

        $mahasiswa = User::findOrFail($request->mahasiswa_id);

        Nilai::findOrFail($id)->update([
            'mahasiswa_id' => $request->mahasiswa_id,
            'mahasiswa'    => $mahasiswa->name,
            'kelas'        => $request->kelas,
            'mata_kuliah'  => $request->mata_kuliah,
            'nilai_tugas'  => $request->nilai_tugas,
            'nilai_uts'    => $request->nilai_uts,
            'nilai_uas'    => $request->nilai_uas,
            'nilai_akhir'  => $nilaiAkhir,
            'grade'        => $grade,
            'status'       => $request->status,
        ]);

        return redirect('/admin/nilai')->with('success', 'Data nilai berhasil diupdate');
    }

    public function destroy($id)
    {
        Nilai::findOrFail($id)->delete();
        return redirect('/admin/nilai')->with('success', 'Data nilai berhasil dihapus');
    }

    // =========================
    // 👨‍🏫 DOSEN (CRUD)
    // =========================
    public function dosenIndex()
{
    $nilais = Nilai::with('mahasiswa')
        ->whereHas('mahasiswa')
        ->get();
    $periodeAktif = $this->getPeriodeNilaiAktif();
    $periodeDibuka = $this->periodeNilaiMasihDibuka();
    return view('dosen.nilai.index', compact('nilais', 'periodeAktif', 'periodeDibuka'));
}

    public function dosenCreate()
    {
        if (!$this->periodeNilaiMasihDibuka()) {
            return redirect()->route('dosen.nilai')
                ->with('error', 'Input nilai ditutup. Batas waktu input nilai sudah berakhir atau belum dibuka oleh admin.');
        }

        $mahasiswas = User::where('role', 'mahasiswa')->get();
        return view('dosen.nilai.create', compact('mahasiswas'));
    }

    public function dosenStore(Request $request)
    {
        if (!$this->periodeNilaiMasihDibuka()) {
            return redirect()->route('dosen.nilai')
                ->with('error', 'Input nilai gagal. Periode input nilai sudah ditutup atau belum dibuka oleh admin.');
        }

        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'kelas'        => 'required|string|max:255',
            'mata_kuliah'  => 'required|string|max:255',
            'nilai_tugas'  => 'required|numeric|min:0|max:100',
            'nilai_uts'    => 'required|numeric|min:0|max:100',
            'nilai_uas'    => 'required|numeric|min:0|max:100',
            'status'       => 'required|in:Lulus,Tidak Lulus',
        ]);

        $nilaiAkhir = ($request->nilai_tugas * 0.30)
                    + ($request->nilai_uts * 0.30)
                    + ($request->nilai_uas * 0.40);

        $grade = match (true) {
            $nilaiAkhir >= 85 => 'A',
            $nilaiAkhir >= 75 => 'B',
            $nilaiAkhir >= 65 => 'C',
            $nilaiAkhir >= 50 => 'D',
            default => 'E',
        };

        $mahasiswa = User::findOrFail($request->mahasiswa_id);

        Nilai::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'mahasiswa'    => $mahasiswa->name,
            'kelas'        => $request->kelas,
            'mata_kuliah'  => $request->mata_kuliah,
            'nilai_tugas'  => $request->nilai_tugas,
            'nilai_uts'    => $request->nilai_uts,
            'nilai_uas'    => $request->nilai_uas,
            'nilai_akhir'  => $nilaiAkhir,
            'grade'        => $grade,
            'status'       => $request->status,
        ]);

        return redirect()->route('dosen.nilai')->with('success', 'Nilai berhasil ditambahkan');
    }

    public function dosenEdit($id)
    {
        if (!$this->periodeNilaiMasihDibuka()) {
            return redirect()->route('dosen.nilai')
                ->with('error', 'Edit nilai ditutup. Batas waktu input nilai sudah berakhir atau belum dibuka oleh admin.');
        }

        $nilai = Nilai::findOrFail($id);
        $mahasiswas = User::where('role', 'mahasiswa')->get();

        return view('dosen.nilai.edit', compact('nilai', 'mahasiswas'));
    }

    public function dosenUpdate(Request $request, $id)
    {
        if (!$this->periodeNilaiMasihDibuka()) {
            return redirect()->route('dosen.nilai')
                ->with('error', 'Update nilai gagal. Periode input nilai sudah ditutup atau belum dibuka oleh admin.');
        }

        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'kelas'        => 'required|string|max:255',
            'mata_kuliah'  => 'required|string|max:255',
            'nilai_tugas'  => 'required|numeric|min:0|max:100',
            'nilai_uts'    => 'required|numeric|min:0|max:100',
            'nilai_uas'    => 'required|numeric|min:0|max:100',
            'status'       => 'required|in:Lulus,Tidak Lulus',
        ]);

        $nilaiAkhir = ($request->nilai_tugas * 0.30)
                    + ($request->nilai_uts * 0.30)
                    + ($request->nilai_uas * 0.40);

        $grade = match (true) {
            $nilaiAkhir >= 85 => 'A',
            $nilaiAkhir >= 75 => 'B',
            $nilaiAkhir >= 65 => 'C',
            $nilaiAkhir >= 50 => 'D',
            default => 'E',
        };

        $mahasiswa = User::findOrFail($request->mahasiswa_id);

        Nilai::findOrFail($id)->update([
            'mahasiswa_id' => $request->mahasiswa_id,
            'mahasiswa'    => $mahasiswa->name,
            'kelas'        => $request->kelas,
            'mata_kuliah'  => $request->mata_kuliah,
            'nilai_tugas'  => $request->nilai_tugas,
            'nilai_uts'    => $request->nilai_uts,
            'nilai_uas'    => $request->nilai_uas,
            'nilai_akhir'  => $nilaiAkhir,
            'grade'        => $grade,
            'status'       => $request->status,
        ]);

        return redirect()->route('dosen.nilai')->with('success', 'Nilai berhasil diupdate');
    }

    public function dosenDestroy($id)
    {
        if (!$this->periodeNilaiMasihDibuka()) {
            return redirect()->route('dosen.nilai')
                ->with('error', 'Hapus nilai ditolak. Periode input nilai sudah ditutup atau belum dibuka oleh admin.');
        }

        Nilai::findOrFail($id)->delete();
        return redirect()->route('dosen.nilai')->with('success', 'Nilai berhasil dihapus');
    }
}
