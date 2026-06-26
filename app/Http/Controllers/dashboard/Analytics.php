<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// TAMBAH INI
use App\Models\User;
use App\Models\Kelas;
use App\Models\Matakuliah;

class Analytics extends Controller
{
  public function index()
  {
    $mahasiswa = User::where('role', 'mahasiswa')->count();
    $dosen = User::where('role', 'dosen')->count();
    $kelas = Kelas::count();
    $matakuliah = Matakuliah::count();

    return view('content.dashboard.dashboards-analytics', compact(
      'mahasiswa',
      'dosen',
      'kelas',
      'matakuliah'
    ));
  }
}
