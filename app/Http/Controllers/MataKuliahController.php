<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    // TAMPIL DATA
    public function index()
    {
        $matakuliah = MataKuliah::all();

        return view('admin.matakuliah.index', compact('matakuliah'));
    }

    // FORM CREATE
    public function create()
    {
        return view('admin.matakuliah.create');
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        MataKuliah::create([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks,
            'kode_dosen' => $request->kode_dosen,
            'dosen_pengampu' => $request->dosen_pengampu,
        ]);

        return redirect('/admin/matakuliah');
    }

    // FORM EDIT
    public function edit($id)
    {
        $matakuliah = MataKuliah::findOrFail($id);

        return view('admin.matakuliah.edit', compact('matakuliah'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $matakuliah = MataKuliah::findOrFail($id);

        $matakuliah->update([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks,
            'dosen_pengampu' => $request->dosen_pengampu,
        ]);

        return redirect('/admin/matakuliah');
    }

    // DELETE
    public function destroy($id)
    {
        $matakuliah = MataKuliah::findOrFail($id);

        $matakuliah->delete();

        return redirect('/admin/matakuliah');
    }
}
