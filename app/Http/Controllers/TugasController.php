<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Kelas;
use App\Models\PengumpulanTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    // =========================
    // 🛠 DOSEN (CRUD TUGAS)
    // =========================

    public function index()
    {
        $tugas = Tugas::with('kelas')
            ->where('dosen_id', Auth::id())
            ->latest()
            ->get();

        return view('dosen.tugas.index', compact('tugas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('dosen.tugas.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'  => 'required|exists:kelas,id',
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'deadline'  => 'required|date',
            'lampiran'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png|max:5120',
        ], [
            'kelas_id.required'  => 'Kelas wajib dipilih.',
            'kelas_id.exists'    => 'Kelas yang dipilih tidak valid.',
            'judul.required'     => 'Judul tugas wajib diisi.',
            'deskripsi.required' => 'Deskripsi tugas wajib diisi.',
            'deadline.required'  => 'Deadline wajib diisi.',
            'deadline.date'      => 'Format deadline tidak valid.',
            'lampiran.file'      => 'Lampiran harus berupa file.',
            'lampiran.mimes'     => 'Format lampiran harus pdf, doc, docx, xls, xlsx, ppt, pptx, zip, rar, jpg, jpeg, atau png.',
            'lampiran.max'       => 'Ukuran lampiran maksimal 5 MB.',
        ]);

        $lampiranPath = null;

        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran_tugas', 'public');
        }

        Tugas::create([
            'kelas_id'  => $request->kelas_id,
            'dosen_id'  => Auth::id(),
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline'  => $request->deadline,
            'lampiran'  => $lampiranPath,
        ]);

        return redirect()
            ->route('dosen.tugas')
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tugas = Tugas::findOrFail($id);
        $kelas = Kelas::all();

        return view('dosen.tugas.edit', compact('tugas', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas_id'  => 'required|exists:kelas,id',
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'deadline'  => 'required|date',
            'lampiran'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png|max:5120',
        ], [
            'kelas_id.required'  => 'Kelas wajib dipilih.',
            'kelas_id.exists'    => 'Kelas yang dipilih tidak valid.',
            'judul.required'     => 'Judul tugas wajib diisi.',
            'deskripsi.required' => 'Deskripsi tugas wajib diisi.',
            'deadline.required'  => 'Deadline wajib diisi.',
            'deadline.date'      => 'Format deadline tidak valid.',
            'lampiran.file'      => 'Lampiran harus berupa file.',
            'lampiran.mimes'     => 'Format lampiran harus pdf, doc, docx, xls, xlsx, ppt, pptx, zip, rar, jpg, jpeg, atau png.',
            'lampiran.max'       => 'Ukuran lampiran maksimal 5 MB.',
        ]);

        $tugas = Tugas::findOrFail($id);

        $lampiranPath = $tugas->lampiran;

        if ($request->hasFile('lampiran')) {
            if ($tugas->lampiran && Storage::disk('public')->exists($tugas->lampiran)) {
                Storage::disk('public')->delete($tugas->lampiran);
            }

            $lampiranPath = $request->file('lampiran')->store('lampiran_tugas', 'public');
        }

        $tugas->update([
            'kelas_id'  => $request->kelas_id,
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline'  => $request->deadline,
            'lampiran'  => $lampiranPath,
        ]);

        return redirect()
            ->route('dosen.tugas')
            ->with('success', 'Tugas berhasil diupdate.');
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);

        if ($tugas->lampiran && Storage::disk('public')->exists($tugas->lampiran)) {
            Storage::disk('public')->delete($tugas->lampiran);
        }

        $tugas->delete();

        return redirect()
            ->route('dosen.tugas')
            ->with('success', 'Tugas berhasil dihapus.');
    }

    // =========================
    // 📥 DOSEN: LIHAT PENGUMPULAN
    // =========================

    public function pengumpulan($id)
    {
        $tugas = Tugas::findOrFail($id);

        $pengumpulan = PengumpulanTugas::with('mahasiswa')
            ->where('tugas_id', $id)
            ->get();

        return view('dosen.tugas.pengumpulan', compact('tugas', 'pengumpulan'));
    }

    public function simpanNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100'
        ], [
            'nilai.required' => 'Nilai wajib diisi.',
            'nilai.numeric'  => 'Nilai harus berupa angka.',
            'nilai.min'      => 'Nilai minimal 0.',
            'nilai.max'      => 'Nilai maksimal 100.',
        ]);

        $pengumpulan = PengumpulanTugas::findOrFail($id);

        $pengumpulan->update([
            'nilai' => $request->nilai
        ]);

        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    // =========================
    // 🎓 MAHASISWA
    // =========================

    public function mahasiswaIndex()
    {
        $tugas = Tugas::with([
            'kelas',
            'pengumpulans' => function ($q) {
                $q->where('mahasiswa_id', Auth::id());
            }
        ])->latest()->get();

        return view('mahasiswa.tugas.index', compact('tugas'));
    }

    public function submit(Request $request, $id)
    {
        $request->validate([
            'link_jawaban' => 'required|url'
        ], [
            'link_jawaban.required' => 'Link jawaban wajib diisi.',
            'link_jawaban.url'      => 'Link jawaban harus berupa URL yang valid.',
        ]);

        PengumpulanTugas::updateOrCreate(
            [
                'mahasiswa_id' => Auth::id(),
                'tugas_id'     => $id
            ],
            [
                'link_jawaban' => $request->link_jawaban,
                'status'       => 'Sudah Dikumpulkan'
            ]
        );

        return back()->with('success', 'Tugas berhasil dikumpulkan.');
    }

    // =========================
    // 🛡 ADMIN (READ ONLY)
    // =========================

    public function adminIndex()
    {
        $tugas = Tugas::with([
            'kelas',
            'dosen',
            'pengumpulans'
        ])->latest()->get();

        return view('admin.tugas.index', compact('tugas'));
    }

    public function adminDetail($id)
    {
        $tugas = Tugas::with([
            'kelas',
            'dosen',
            'pengumpulans.mahasiswa'
        ])->findOrFail($id);

        return view('admin.tugas.detail', compact('tugas'));
    }
}
