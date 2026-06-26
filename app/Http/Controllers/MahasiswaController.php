<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\User;
use App\Models\Kelas;
use App\Models\KelasMahasiswa;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $mahasiswaId = Auth::id();

        // Ambil semua kelas yang diikuti mahasiswa login
        $kelasIds = KelasMahasiswa::where('mahasiswa_id', $mahasiswaId)
            ->pluck('kelas_id');

        // Total kelas aktif
        $totalKelas = Kelas::whereIn('id', $kelasIds)
            ->where('status', 'approved')
            ->count();

        // Default jika model belum ada data
        $totalTugas = 0;
        $deadlineMingguIni = 0;
        $deadlineTugas = collect();
        $materiTerbaru = collect();

        // Data tugas
        if (class_exists(\App\Models\Tugas::class)) {
            $totalTugas = \App\Models\Tugas::whereIn('kelas_id', $kelasIds)
                ->count();

            // Ambil deadline minggu ini
            $deadlineTugas = \App\Models\Tugas::whereIn('kelas_id', $kelasIds)
                ->whereBetween('deadline', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])
                ->orderBy('deadline', 'asc')
                ->take(5)
                ->get();

            // Angka deadline harus sama dengan list deadline
            $deadlineMingguIni = $deadlineTugas->count();
        }

        // Data materi terbaru
        if (class_exists(\App\Models\Materi::class)) {
            $materiTerbaru = \App\Models\Materi::whereIn('kelas_id', $kelasIds)
                ->orderBy('id', 'desc')
                ->take(5)
                ->get();
        }

        // Rata-rata nilai dari kolom nilai_akhir
        $rataRataNilai = Nilai::where('mahasiswa_id', $mahasiswaId)
            ->avg('nilai_akhir');

        $rataRataNilai = $rataRataNilai ? round($rataRataNilai) : 0;

        // Nilai terbaru mahasiswa
        $nilaiTerbaru = Nilai::where('mahasiswa_id', $mahasiswaId)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'totalKelas',
            'totalTugas',
            'deadlineMingguIni',
            'rataRataNilai',
            'materiTerbaru',
            'deadlineTugas',
            'nilaiTerbaru'
        ));
    }

    public function materi()
    {
        return view('mahasiswa.materi');
    }

    public function tugas()
    {
        return view('mahasiswa.tugas');
    }

    public function nilai()
    {
        $nilais = Nilai::where('mahasiswa_id', Auth::id())->get();

        return view('mahasiswa.nilai', compact('nilais'));
    }

    public function profil()
    {
        return view('mahasiswa.profil');
    }

    public function dosenIndex()
    {
        $mahasiswas = User::where('role', 'mahasiswa')->get();

        return view('dosen.mahasiswa.index', compact('mahasiswas'));
    }
}
