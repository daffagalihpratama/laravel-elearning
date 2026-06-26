<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MataKuliah;
use App\Models\Nilai;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // TOTAL MAHASISWA
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();

        // TOTAL DOSEN
        $totalDosen = User::where('role', 'dosen')->count();

        // TOTAL MATA KULIAH
        $totalMatkul = MataKuliah::count();

        // TOTAL NILAI
        $totalNilai = Nilai::count();

        // NILAI TERBARU
        $nilaiTerbaru = Nilai::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalMatkul',
            'totalNilai',
            'nilaiTerbaru'
        ));
    }
}
