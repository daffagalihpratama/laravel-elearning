<?php

namespace App\Http\Controllers;

use App\Models\PeriodeNilai;
use Illuminate\Http\Request;

class PeriodeNilaiController extends Controller
{
    public function index()
    {
        $periodes = PeriodeNilai::latest()->get();
        return view('admin.periode_nilai.index', compact('periodes'));
    }

    public function create()
    {
        return view('admin.periode_nilai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mulai_input'    => 'required|date',
            'deadline_input' => 'required|date|after:mulai_input',
            'is_active'      => 'required|boolean',
        ], [
            'deadline_input.after' => 'Deadline input harus lebih besar dari mulai input.',
        ]);

        if ($request->is_active == 1) {
            PeriodeNilai::where('is_active', true)->update(['is_active' => false]);
        }

        PeriodeNilai::create([
            'mulai_input'    => $request->mulai_input,
            'deadline_input' => $request->deadline_input,
            'is_active'      => $request->is_active,
        ]);

        return redirect()->route('admin.periode-nilai.index')
            ->with('success', 'Periode nilai berhasil ditambahkan.');
    }
}
