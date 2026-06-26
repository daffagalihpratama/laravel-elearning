<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Materi;
use App\Models\MataKuliah;
use App\Models\KelasMahasiswa;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $kelas = Kelas::with('mataKuliah')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $matakuliah = MataKuliah::all();
        $dosens = User::where('role', 'dosen')->get();

        return view('admin.kelas.create', compact('matakuliah', 'dosens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'nama_kelas'     => 'required|string|max:255',
            'semester'       => 'required',
            'dosen'          => 'required|string|max:255',
            'hari'           => 'required|string|max:50',
            'jam_mulai'      => 'required|date_format:H:i',
            'jam_selesai'    => 'required|date_format:H:i|after:jam_mulai',
            'ruangan'        => 'nullable|string|max:100',
        ], [
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
            'mata_kuliah_id.exists'   => 'Mata kuliah tidak valid.',
            'nama_kelas.required'     => 'Nama kelas wajib diisi.',
            'semester.required'       => 'Semester wajib diisi.',
            'dosen.required'          => 'Dosen wajib dipilih.',
            'hari.required'           => 'Hari wajib diisi.',
            'jam_mulai.required'      => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format'   => 'Format jam mulai harus HH:MM.',
            'jam_selesai.required'    => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai harus HH:MM.',
            'jam_selesai.after'       => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);

        Kelas::create([
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'nama_kelas'     => $request->nama_kelas,
            'semester'       => $request->semester,
            'dosen'          => $request->dosen,
            'hari'           => $request->hari,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'ruangan'        => $request->ruangan,
            'status'         => 'approved',
        ]);

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function approve($id)
    {
        $kelas = Kelas::findOrFail($id);

        $kelas->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Kelas berhasil di-ACC.');
    }

    public function reject($id)
    {
        $kelas = Kelas::findOrFail($id);

        $kelas->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Kelas berhasil ditolak.');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $matakuliah = MataKuliah::all();
        $dosens = User::where('role', 'dosen')->get();

        return view('admin.kelas.edit', compact('kelas', 'matakuliah', 'dosens'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'nama_kelas'     => 'required|string|max:255',
            'semester'       => 'required',
            'dosen'          => 'required|string|max:255',
            'hari'           => 'required|string|max:50',
            'jam_mulai'      => 'required|date_format:H:i',
            'jam_selesai'    => 'required|date_format:H:i|after:jam_mulai',
            'ruangan'        => 'nullable|string|max:100',
        ], [
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
            'mata_kuliah_id.exists'   => 'Mata kuliah tidak valid.',
            'nama_kelas.required'     => 'Nama kelas wajib diisi.',
            'semester.required'       => 'Semester wajib diisi.',
            'dosen.required'          => 'Dosen wajib dipilih.',
            'hari.required'           => 'Hari wajib diisi.',
            'jam_mulai.required'      => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format'   => 'Format jam mulai harus HH:MM.',
            'jam_selesai.required'    => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai harus HH:MM.',
            'jam_selesai.after'       => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);

        $kelas = Kelas::findOrFail($id);

        $kelas->update([
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'nama_kelas'     => $request->nama_kelas,
            'semester'       => $request->semester,
            'dosen'          => $request->dosen,
            'hari'           => $request->hari,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'ruangan'        => $request->ruangan,
        ]);

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data kelas berhasil diupdate.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);

        KelasMahasiswa::where('kelas_id', $kelas->id)->delete();
        Materi::where('kelas_id', $kelas->id)->delete();

        $kelas->delete();

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | DOSEN
    |--------------------------------------------------------------------------
    */

    public function dosenIndex()
    {
        $kelas = Kelas::with('mataKuliah')
            ->where('dosen', auth()->user()->name)
            ->where('status', 'approved')
            ->orderBy('nama_kelas')
            ->get();

        return view('dosen.kelas.index', compact('kelas'));
    }

    public function createDosen()
    {
        $matakuliah = MataKuliah::all();

        return view('dosen.kelas.create', compact('matakuliah'));
    }

    public function storeDosen(Request $request)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'nama_kelas'     => 'required|string|max:255',
            'semester'       => 'required',
            'hari'           => 'required|string|max:50',
            'jam_mulai'      => 'required|date_format:H:i',
            'jam_selesai'    => 'required|date_format:H:i|after:jam_mulai',
            'ruangan'        => 'nullable|string|max:100',
        ], [
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
            'mata_kuliah_id.exists'   => 'Mata kuliah tidak valid.',
            'nama_kelas.required'     => 'Nama kelas wajib diisi.',
            'semester.required'       => 'Semester wajib diisi.',
            'hari.required'           => 'Hari wajib diisi.',
            'jam_mulai.required'      => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format'   => 'Format jam mulai harus HH:MM.',
            'jam_selesai.required'    => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai harus HH:MM.',
            'jam_selesai.after'       => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);

        Kelas::create([
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'nama_kelas'     => $request->nama_kelas,
            'semester'       => $request->semester,
            'dosen'          => auth()->user()->name,
            'hari'           => $request->hari,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'ruangan'        => $request->ruangan,
            'status'         => 'pending',
        ]);

        return redirect()
            ->route('dosen.kelas')
            ->with('success', 'Kelas berhasil diajukan dan menunggu ACC Admin.');
    }

    /*
    |--------------------------------------------------------------------------
    | MAHASISWA
    |--------------------------------------------------------------------------
    */

    public function mahasiswaIndex()
    {
        $mahasiswaId = auth()->id();

        $kelasIds = KelasMahasiswa::where('mahasiswa_id', $mahasiswaId)
            ->pluck('kelas_id');

        if ($kelasIds->isEmpty()) {
            $kelas = collect();

            return view('mahasiswa.kelas.index', compact('kelas'));
        }

        $kelas = Kelas::with('mataKuliah')
            ->where('status', 'approved')
            ->whereIn('id', $kelasIds)
            ->orderBy('nama_kelas')
            ->get();

        return view('mahasiswa.kelas.index', compact('kelas'));
    }

    public function mahasiswaDetail($id)
    {
        $mahasiswaId = auth()->id();

        $kelas = Kelas::with('mataKuliah')
            ->where('status', 'approved')
            ->where('id', $id)
            ->firstOrFail();

        $terdaftar = KelasMahasiswa::where('kelas_id', $kelas->id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->exists();

        if (! $terdaftar) {
            return redirect()
                ->route('mahasiswa.kelas')
                ->with('error', 'Kamu tidak terdaftar di kelas ini.');
        }

        $absensiMahasiswa = Absensi::where('kelas_id', $kelas->id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->whereDate('tanggal', today())
            ->first();

        return view('mahasiswa.kelas.detail', compact(
            'kelas',
            'absensiMahasiswa'
        ));
    }
}
