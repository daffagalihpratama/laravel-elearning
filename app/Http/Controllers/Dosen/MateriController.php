<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Kelas;

class MateriController extends Controller
{
    public function index()
    {
        $materi = Materi::with('kelas')->latest()->get();

        return view('dosen.materi.index', compact('materi'));
    }

    public function create()
    {
        $kelas = Kelas::all();

        return view('dosen.materi.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'judul' => 'required',
            'pertemuan' => 'required',
        ]);

        $fileName = null;

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $fileName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('materi'), $fileName);
        }

        Materi::create([
            'kelas_id' => $request->kelas_id,
            'dosen_id' => auth()->id(),
            'judul' => $request->judul,
            'pertemuan' => $request->pertemuan,
            'deskripsi' => $request->deskripsi,
            'file' => $fileName
        ]);

        return redirect()
            ->route('dosen.materi')
            ->with('success', 'Materi berhasil ditambahkan');
    }
}
