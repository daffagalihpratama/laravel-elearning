<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\KelasMahasiswa;
use App\Models\User;
use App\Models\KelasPengganti;
use App\Models\AbsensiKelasPengganti;

class AbsensiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MAHASISWA
    |--------------------------------------------------------------------------
    */

    public function index()
{
    $mahasiswaId = auth()->id();

    $kelasIds = KelasMahasiswa::where('mahasiswa_id', $mahasiswaId)
        ->pluck('kelas_id');

    $kelas = Kelas::with('mataKuliah')
        ->where('status', 'approved')
        ->whereIn('id', $kelasIds)
        ->get();

    foreach ($kelas as $item) {

        // ==========================
        // ABSENSI KELAS UTAMA
        // ==========================
        $hadirKelasUtama = Absensi::where('mahasiswa_id', $mahasiswaId)
            ->where('kelas_id', $item->id)
            ->where('status', 'Hadir')
            ->count();

        $tidakHadirKelasUtama = Absensi::where('mahasiswa_id', $mahasiswaId)
            ->where('kelas_id', $item->id)
            ->where('status', '!=', 'Hadir')
            ->count();

        // ==========================
        // ABSENSI KELAS PENGGANTI / KP
        // ==========================
        $kelasPengganti = KelasPengganti::where('kelas_id', $item->id)
            ->where('status', 'approved')
            ->get();

        $kelasPenggantiIds = $kelasPengganti->pluck('id');

        $hadirKp = AbsensiKelasPengganti::where('mahasiswa_id', $mahasiswaId)
            ->whereIn('kelas_pengganti_id', $kelasPenggantiIds)
            ->where('status', 'Hadir')
            ->count();

        $tidakHadirKp = AbsensiKelasPengganti::where('mahasiswa_id', $mahasiswaId)
            ->whereIn('kelas_pengganti_id', $kelasPenggantiIds)
            ->where('status', '!=', 'Hadir')
            ->count();

        // ==========================
        // TOTAL KELAS UTAMA + KP
        // ==========================
        $hadir = $hadirKelasUtama + $hadirKp;
        $tidakHadir = $tidakHadirKelasUtama + $tidakHadirKp;

        $total = $hadir + $tidakHadir;

        $item->hadir = $hadir;
        $item->tidak_hadir = $tidakHadir;
        $item->persentase = $total > 0
            ? round(($hadir / $total) * 100, 1)
            : 0;

        // ==========================
        // KODE KP
        // Karena tabel kamu belum ada kode_kp,
        // kita bikin otomatis dari ID: KP001, KP002, dst.
        // ==========================
        $item->kode_kp = $kelasPengganti->map(function ($kp) {
            return 'KP' . str_pad($kp->id, 3, '0', STR_PAD_LEFT);
        })->implode(', ');
    }

    return view('mahasiswa.absensi.index', compact('kelas'));
}

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'kelas_id.required' => 'Kelas tidak valid.',
            'kelas_id.exists'   => 'Kelas tidak ditemukan.',
        ]);

        $mahasiswaId = auth()->id();

        $kelas = Kelas::where('id', $request->kelas_id)
            ->where('status', 'approved')
            ->firstOrFail();

        $terdaftar = KelasMahasiswa::where('kelas_id', $kelas->id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->exists();

        if (! $terdaftar) {
            return redirect()
                ->back()
                ->with('error', 'Kamu tidak terdaftar di kelas ini.');
        }

        if (! $kelas->is_absen_open) {
            return redirect()
                ->back()
                ->with('error', 'Absensi belum dibuka oleh dosen.');
        }

        $absensi = Absensi::where('mahasiswa_id', $mahasiswaId)
            ->where('kelas_id', $kelas->id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        if ($absensi) {
            if (in_array($absensi->status, ['Hadir', 'Izin', 'Sakit'], true)) {
                return redirect()
                    ->back()
                    ->with('error', 'Kamu sudah melakukan absensi hari ini.');
            }

            $absensi->update([
                'status' => 'Hadir',
            ]);

            return redirect()
                ->back()
                ->with('success', 'Absensi berhasil. Kamu tercatat hadir.');
        }

        $pertemuanKe = $this->getPertemuanHariIni($kelas->id);

        Absensi::create([
            'mahasiswa_id' => $mahasiswaId,
            'kelas_id'     => $kelas->id,
            'pertemuan_ke' => $pertemuanKe,
            'tanggal'      => now()->toDateString(),
            'status'       => 'Hadir',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Absensi berhasil. Kamu tercatat hadir.');
    }

    /*
    |--------------------------------------------------------------------------
    | DOSEN - ABSENSI KELAS UTAMA
    |--------------------------------------------------------------------------
    */

    public function dosenBukaAbsensi($id)
    {
        $kelas = Kelas::where('id', $id)
            ->where('dosen', auth()->user()->name)
            ->firstOrFail();

        $kelas->update([
            'is_absen_open' => true,
        ]);

        $pertemuanKe = $this->getPertemuanHariIni($kelas->id);

        $mahasiswaTerdaftar = KelasMahasiswa::where('kelas_id', $kelas->id)->get();

        foreach ($mahasiswaTerdaftar as $km) {
            Absensi::firstOrCreate(
                [
                    'kelas_id'     => $kelas->id,
                    'mahasiswa_id' => $km->mahasiswa_id,
                    'tanggal'      => now()->toDateString(),
                ],
                [
                    'pertemuan_ke' => $pertemuanKe,
                    'status'       => 'Alfa',
                ]
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Absensi berhasil dibuka.');
    }

    public function dosenTutupAbsensi($id)
    {
        $kelas = Kelas::where('id', $id)
            ->where('dosen', auth()->user()->name)
            ->firstOrFail();

        $kelas->update([
            'is_absen_open' => false,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Absensi berhasil ditutup.');
    }

    public function dosenDetail($id)
    {
        $kelas = Kelas::with('mataKuliah')
            ->where('id', $id)
            ->where('dosen', auth()->user()->name)
            ->firstOrFail();

        $mahasiswaList = KelasMahasiswa::where('kelas_id', $kelas->id)
            ->with('mahasiswa')
            ->get();

        $pertemuanList = Absensi::where('kelas_id', $kelas->id)
            ->select('pertemuan_ke', 'tanggal')
            ->groupBy('pertemuan_ke', 'tanggal')
            ->orderBy('pertemuan_ke')
            ->get();

        $idSudahAda = $mahasiswaList->pluck('mahasiswa_id')->toArray();

        $semuaMahasiswa = User::where('role', 'mahasiswa')
            ->whereNotIn('id', $idSudahAda)
            ->orderBy('name')
            ->get();

        $semuaAbsensi = Absensi::where('kelas_id', $kelas->id)->get();

        $absensiData = [];

        foreach ($semuaAbsensi as $a) {
            $absensiData[$a->mahasiswa_id][$a->pertemuan_ke] = strtoupper(substr($a->status, 0, 1));
        }

        $totalHadir = $semuaAbsensi->where('status', 'Hadir')->count();
        $totalIzin = $semuaAbsensi->where('status', 'Izin')->count();
        $totalSakit = $semuaAbsensi->where('status', 'Sakit')->count();
        $totalAlpha = $semuaAbsensi->where('status', 'Alfa')->count();

        return view('dosen.absensi.detail', compact(
            'kelas',
            'absensiData',
            'semuaMahasiswa',
            'mahasiswaList',
            'pertemuanList',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlpha'
        ));
    }

    public function dosenUpdateAbsensiManual(Request $request, $kelasId)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'pertemuan_ke' => 'required|integer|min:1',
            'tanggal'      => 'required|date',
            'status'       => 'required|in:Hadir,Izin,Sakit,Alfa',
        ], [
            'mahasiswa_id.required' => 'Mahasiswa wajib dipilih.',
            'mahasiswa_id.exists'   => 'Mahasiswa tidak valid.',
            'pertemuan_ke.required' => 'Pertemuan wajib diisi.',
            'pertemuan_ke.integer'  => 'Pertemuan harus berupa angka.',
            'tanggal.required'      => 'Tanggal wajib diisi.',
            'tanggal.date'          => 'Tanggal tidak valid.',
            'status.required'       => 'Status wajib dipilih.',
            'status.in'             => 'Status tidak valid.',
        ]);

        $kelas = Kelas::where('id', $kelasId)
            ->where('dosen', auth()->user()->name)
            ->firstOrFail();

        Absensi::updateOrCreate(
            [
                'kelas_id'     => $kelas->id,
                'mahasiswa_id' => $request->mahasiswa_id,
                'pertemuan_ke' => $request->pertemuan_ke,
            ],
            [
                'tanggal' => $request->tanggal,
                'status'  => $request->status,
            ]
        );

        return redirect()
            ->back()
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    public function dosenSimpanBap(Request $request, $kelasId)
    {
        $request->validate([
            'bap_pertemuan'    => 'required|integer|min:1',
            'bap_rangkuman'    => 'required|string|max:255',
            'bap_berita_acara' => 'required|string',
        ], [
            'bap_pertemuan.required'    => 'Pertemuan wajib diisi.',
            'bap_pertemuan.integer'     => 'Pertemuan harus berupa angka.',
            'bap_pertemuan.min'         => 'Pertemuan minimal 1.',
            'bap_rangkuman.required'    => 'Rangkuman materi wajib diisi.',
            'bap_rangkuman.string'      => 'Rangkuman materi tidak valid.',
            'bap_rangkuman.max'         => 'Rangkuman materi maksimal 255 karakter.',
            'bap_berita_acara.required' => 'Berita acara wajib diisi.',
            'bap_berita_acara.string'   => 'Berita acara tidak valid.',
        ]);

        $kelas = Kelas::where('id', $kelasId)
            ->where('dosen', auth()->user()->name)
            ->firstOrFail();

        $kelas->bap_pertemuan = $request->bap_pertemuan;
        $kelas->bap_rangkuman = $request->bap_rangkuman;
        $kelas->bap_berita_acara = $request->bap_berita_acara;
        $kelas->bap_diisi_pada = now();
        $kelas->save();

        return redirect()
            ->back()
            ->with('success', 'BAP perkuliahan berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | DOSEN - KELOLA MAHASISWA KELAS UTAMA
    |--------------------------------------------------------------------------
    */

    public function dosenTambahMahasiswa(Request $request, $kelasId)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
        ], [
            'mahasiswa_id.required' => 'Mahasiswa wajib dipilih.',
            'mahasiswa_id.exists'   => 'Mahasiswa tidak valid.',
        ]);

        $kelas = Kelas::where('id', $kelasId)
            ->where('dosen', auth()->user()->name)
            ->firstOrFail();

        $mahasiswa = User::where('id', $request->mahasiswa_id)
            ->where('role', 'mahasiswa')
            ->firstOrFail();

        KelasMahasiswa::firstOrCreate([
            'kelas_id'     => $kelas->id,
            'mahasiswa_id' => $mahasiswa->id,
        ]);

        if ($kelas->is_absen_open) {
            $pertemuanKe = $this->getPertemuanHariIni($kelas->id);

            Absensi::firstOrCreate(
                [
                    'kelas_id'     => $kelas->id,
                    'mahasiswa_id' => $mahasiswa->id,
                    'tanggal'      => now()->toDateString(),
                ],
                [
                    'pertemuan_ke' => $pertemuanKe,
                    'status'       => 'Alfa',
                ]
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Mahasiswa berhasil ditambahkan ke kelas.');
    }

    public function dosenHapusMahasiswa($kelasId, $mahasiswaId)
    {
        $kelas = Kelas::where('id', $kelasId)
            ->where('dosen', auth()->user()->name)
            ->firstOrFail();

        KelasMahasiswa::where('kelas_id', $kelas->id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->delete();

        return redirect()
            ->back()
            ->with('success', 'Mahasiswa berhasil dihapus dari kelas.');
    }

    public function dosenEditMahasiswa($kelasId, $mahasiswaId)
    {
        $kelas = Kelas::where('id', $kelasId)
            ->where('dosen', auth()->user()->name)
            ->firstOrFail();

        $mahasiswa = User::where('id', $mahasiswaId)
            ->where('role', 'mahasiswa')
            ->firstOrFail();

        $absensi = Absensi::where('kelas_id', $kelas->id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('pertemuan_ke')
            ->get();

        return view('dosen.absensi.edit_mahasiswa', compact(
            'kelas',
            'mahasiswa',
            'absensi'
        ));
    }

    public function dosenUpdateMahasiswaAbsensi(Request $request, $kelasId, $mahasiswaId)
    {
        $kelas = Kelas::where('id', $kelasId)
            ->where('dosen', auth()->user()->name)
            ->firstOrFail();

        $mahasiswa = User::where('id', $mahasiswaId)
            ->where('role', 'mahasiswa')
            ->firstOrFail();

        $request->validate([
            'status'   => 'required|array',
            'status.*' => 'required|in:Hadir,Izin,Sakit,Alfa',
        ], [
            'status.required'   => 'Data status absensi wajib diisi.',
            'status.array'      => 'Format status absensi tidak valid.',
            'status.*.required' => 'Status absensi wajib dipilih.',
            'status.*.in'       => 'Status absensi tidak valid.',
        ]);

        foreach ($request->status as $absensiId => $status) {
            Absensi::where('id', $absensiId)
                ->where('kelas_id', $kelas->id)
                ->where('mahasiswa_id', $mahasiswa->id)
                ->update([
                    'status' => $status,
                ]);
        }

        return redirect()
            ->route('dosen.absensi.edit-mahasiswa', [$kelas->id, $mahasiswa->id])
            ->with('success', 'Data absensi mahasiswa berhasil diperbarui.');
    }

    public function dosenHapusMahasiswaAbsensi($kelasId, $mahasiswaId)
    {
        $kelas = Kelas::where('id', $kelasId)
            ->where('dosen', auth()->user()->name)
            ->firstOrFail();

        Absensi::where('kelas_id', $kelas->id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->delete();

        return redirect()
            ->back()
            ->with('success', 'Data absensi mahasiswa berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    private function getPertemuanHariIni($kelasId)
    {
        $pertemuanHariIni = Absensi::where('kelas_id', $kelasId)
            ->whereDate('tanggal', now()->toDateString())
            ->max('pertemuan_ke');

        if ($pertemuanHariIni) {
            return $pertemuanHariIni;
        }

        $pertemuanTerakhir = Absensi::where('kelas_id', $kelasId)
            ->max('pertemuan_ke');

        return ($pertemuanTerakhir ?? 0) + 1;
    }
}
