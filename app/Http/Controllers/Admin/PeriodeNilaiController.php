<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeNilai;
use Illuminate\Http\Request;

class PeriodeNilaiController extends Controller
{
    public function index()
    {
        $periodes = PeriodeNilai::orderBy('mulai_input', 'desc')->get();

        return view('admin.periode_nilai.index', compact('periodes'));
    }

    public function create()
    {
        return view('admin.periode_nilai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mulai_input' => 'required|date',
            'deadline_input' => 'required|date|after:mulai_input',
            'keterangan' => 'nullable|string',
            'is_active' => 'nullable',
        ]);

        if ($request->has('is_active')) {
            PeriodeNilai::where('is_active', 1)->update([
                'is_active' => 0,
            ]);
        }

        PeriodeNilai::create([
            'mulai_input' => $request->mulai_input,
            'deadline_input' => $request->deadline_input,
            'keterangan' => $request->keterangan,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.periode-nilai.index')
            ->with('success', 'Periode nilai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $periode = PeriodeNilai::findOrFail($id);

        return view('admin.periode_nilai.edit', compact('periode'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mulai_input' => 'required|date',
            'deadline_input' => 'required|date|after:mulai_input',
            'keterangan' => 'nullable|string',
            'is_active' => 'nullable',
        ]);

        $periode = PeriodeNilai::findOrFail($id);

        if ($request->has('is_active')) {
            PeriodeNilai::where('id', '!=', $periode->id)->update([
                'is_active' => 0,
            ]);
        }

        $periode->update([
            'mulai_input' => $request->mulai_input,
            'deadline_input' => $request->deadline_input,
            'keterangan' => $request->keterangan,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.periode-nilai.index')
            ->with('success', 'Periode nilai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $periode = PeriodeNilai::findOrFail($id);
        $periode->delete();

        return redirect()
            ->route('admin.periode-nilai.index')
            ->with('success', 'Periode nilai berhasil dihapus.');
    }
}
