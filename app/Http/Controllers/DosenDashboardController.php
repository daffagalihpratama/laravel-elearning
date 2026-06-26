<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\User;

class DosenDashboardController extends Controller
{
    public function index()
    {
        $kelas = Kelas::where('dosen', auth()->user()->name)
                      ->where('status', 'approved')
                      ->get();

        $totalKelas    = $kelas->count();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();

        return view('dosen.dashboard', compact('kelas', 'totalKelas', 'totalMahasiswa'));
    }
}
