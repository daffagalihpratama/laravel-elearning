<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasPengganti;
use App\Models\KelasMahasiswa;
use App\Models\AbsensiKelasPengganti;
use App\Models\BapKelasPengganti;
use App\Models\User;
use Illuminate\Http\Request;

class AbsensiKelasPenggantiController extends Controller
{
    // =================== ADMIN ===================

    public function adminKelasList()
    {
        $kelas = Kelas::with(['mataKuliah', 'kelasMahasiswa'])->get();

        return view('admin.kelas_mahasiswa.index', compact('kelas'));
    }

    public function adminKelasMahasiswa($kelasId)
    {
        $kelas = Kelas::with('mataKuliah')->findOrFail($kelasId);

        $mahasiswaTerdaftar = KelasMahasiswa::where('kelas_id', $kelasId)
            ->with('mahasiswa')
            ->get();

        $sudahTerdaftar = KelasMahasiswa::where('kelas_id', $kelasId)
            ->pluck('mahasiswa_id');

        $semuaMahasiswa = User::where('role', 'mahasiswa')
            ->whereNotIn('id', $sudahTerdaftar)
            ->get();

        return view('admin.kelas_mahasiswa.show', compact(
            'kelas',
            'mahasiswaTerdaftar',
            'semuaMahasiswa'
        ));
    }

    public function adminTambahMahasiswa(Request $request, $kelasId)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
        ], [
            'mahasiswa_id.required' => 'Mahasiswa wajib dipilih.',
            'mahasiswa_id.exists'   => 'Mahasiswa yang dipilih tidak valid.',
        ]);

        KelasMahasiswa::firstOrCreate([
            'kelas_id'     => $kelasId,
            'mahasiswa_id' => $request->mahasiswa_id,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Mahasiswa berhasil ditambahkan ke kelas.');
    }

    public function adminHapusMahasiswa($kelasId, $mahasiswaId)
    {
        KelasMahasiswa::where('kelas_id', $kelasId)
            ->where('mahasiswa_id', $mahasiswaId)
            ->delete();

        return redirect()
            ->back()
            ->with('success', 'Mahasiswa berhasil dihapus dari kelas.');
    }

    // =================== DOSEN ===================

    public function dosenBukaAbsensi($id)
    {
        $kelasPengganti = KelasPengganti::where('id', $id)
            ->where('dosen', auth()->user()->name)
            ->where('status', 'approved')
            ->firstOrFail();

        $kelas = Kelas::with('mataKuliah')
            ->where('id', $kelasPengganti->kelas_id)
            ->first();

        if (!$kelas) {
            $kelas = Kelas::with('mataKuliah')
                ->where('nama_kelas', $kelasPengganti->nama_kelas)
                ->first();
        }

        if ($kelas) {
    $mahasiswaTerdaftar = KelasMahasiswa::where('kelas_id', $kelas->id)
        ->with('mahasiswa')
        ->get();

    foreach ($mahasiswaTerdaftar as $km) {
        AbsensiKelasPengganti::updateOrCreate(
            [
                'kelas_pengganti_id' => $kelasPengganti->id,
                'mahasiswa_id'       => $km->mahasiswa_id,
            ],
            [
                'status' => AbsensiKelasPengganti::where('kelas_pengganti_id', $kelasPengganti->id)
                    ->where('mahasiswa_id', $km->mahasiswa_id)
                    ->value('status') ?? 'Alfa',
            ]
        );
    }
}

        $absensi = AbsensiKelasPengganti::where('kelas_pengganti_id', $kelasPengganti->id)
            ->with('mahasiswa')
            ->get();

        $bap = BapKelasPengganti::where('kelas_pengganti_id', $kelasPengganti->id)
            ->first();

        $rekap = [
            'total' => $absensi->count(),
            'hadir' => $absensi->where('status', 'Hadir')->count(),
            'izin'  => $absensi->where('status', 'Izin')->count(),
            'sakit' => $absensi->where('status', 'Sakit')->count(),
            'alfa'  => $absensi->where('status', 'Alfa')->count(),
        ];

        return view('dosen.kelas_pengganti.absensi', compact(
            'kelasPengganti',
            'kelas',
            'absensi',
            'bap',
            'rekap'
        ));
    }

    public function dosenSimpanBap(Request $request, $id)
    {
        $request->validate([
            'materi'              => 'required|string',
            'metode_pembelajaran' => 'nullable|string|max:255',
            'catatan_dosen'       => 'nullable|string',
        ], [
            'materi.required' => 'Materi perkuliahan wajib diisi.',
        ]);

        $kelasPengganti = KelasPengganti::where('id', $id)
            ->where('dosen', auth()->user()->name)
            ->where('status', 'approved')
            ->firstOrFail();

        BapKelasPengganti::updateOrCreate(
            [
                'kelas_pengganti_id' => $kelasPengganti->id,
            ],
            [
                'materi'              => $request->materi,
                'metode_pembelajaran' => $request->metode_pembelajaran,
                'catatan_dosen'       => $request->catatan_dosen,
            ]
        );

        return redirect()
            ->back()
            ->with('success', 'BAP kelas pengganti berhasil disimpan.');
    }

    public function dosenUpdateAbsensi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Izin,Sakit,Alfa',
        ], [
            'status.required' => 'Status absensi wajib dipilih.',
            'status.in'       => 'Status absensi tidak valid.',
        ]);

        $absensi = AbsensiKelasPengganti::with('kelasPengganti')
            ->findOrFail($id);

        $kelasPengganti = $absensi->kelasPengganti;

        if (!$kelasPengganti || $kelasPengganti->dosen !== auth()->user()->name) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah absensi ini.');
        }

        $absensi->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status absensi berhasil diubah.');
    }

    // =================== MAHASISWA ===================

    public function mahasiswaAbsen(Request $request, $id)
    {
        $kelasPengganti = KelasPengganti::where('id', $id)
            ->where('status', 'approved')
            ->firstOrFail();

        $terdaftar = KelasMahasiswa::where('mahasiswa_id', auth()->id())
            ->where('kelas_id', $kelasPengganti->kelas_id)
            ->exists();

        if (!$terdaftar) {
            return redirect()
                ->back()
                ->with('error', 'Kamu tidak terdaftar di kelas ini.');
        }

        $bap = BapKelasPengganti::where('kelas_pengganti_id', $kelasPengganti->id)
            ->first();

        if (!$bap) {
            return redirect()
                ->back()
                ->with('error', 'Absensi belum dapat dilakukan karena BAP belum diisi oleh dosen.');
        }

        $absensi = AbsensiKelasPengganti::where('kelas_pengganti_id', $kelasPengganti->id)
            ->where('mahasiswa_id', auth()->id())
            ->first();

        if (!$absensi) {
            return redirect()
                ->back()
                ->with('error', 'Absensi belum dibuka oleh dosen.');
        }

        if (in_array($absensi->status, ['Hadir', 'Izin', 'Sakit'])) {
            return redirect()
                ->back()
                ->with('error', 'Kamu sudah melakukan absensi.');
        }

        $absensi->update([
            'status' => 'Hadir',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Absensi berhasil. Kamu tercatat Hadir.');
    }
}
