<?php

namespace App\Http\Controllers;

use App\Models\AbsensiKelasPengganti;
use App\Models\BapKelasPengganti;
use App\Models\Kelas;
use App\Models\KelasMahasiswa;
use App\Models\KelasPengganti;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class KelasPenggantiController extends Controller
{
    // ===================== DOSEN =====================

    public function dosenIndex()
    {
        $kelasPengganti = KelasPengganti::where('dosen', auth()->user()->name)
            ->orderByDesc('created_at')
            ->get();

        return view('dosen.kelas_pengganti.index', compact('kelasPengganti'));
    }

    public function dosenCreate()
    {
        $kelas = Kelas::with('mataKuliah')
            ->where('dosen', auth()->user()->name)
            ->orderBy('nama_kelas')
            ->get();

        return view('dosen.kelas_pengganti.create', compact('kelas'));
    }

    public function dosenStore(Request $request)
    {
        $request->validate([
            'kelas_id' => [
                'required',
                Rule::exists('kelas', 'id')->where(function ($query) {
                    $query->where('dosen', auth()->user()->name);
                }),
            ],
            'pertemuan' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('kelas_pengganti', 'pertemuan')->where(function ($query) use ($request) {
                    $query->where('kelas_id', $request->kelas_id);
                }),
            ],
            'hari'              => 'required|string|max:20',
            'jam_mulai'         => 'required|date_format:H:i',
            'jam_selesai'       => 'required|date_format:H:i|after:jam_mulai',
            'ruangan'           => 'required|string|max:100',
            'tanggal_ganti_kp'  => 'required|date',
            'tanggal_pengganti' => 'required|date|after_or_equal:tanggal_ganti_kp',
            'alasan'            => 'required|string',
        ], [
            'kelas_id.required'                => 'Kelas wajib dipilih.',
            'kelas_id.exists'                  => 'Kelas yang dipilih tidak valid atau bukan milik Anda.',
            'pertemuan.required'               => 'Pertemuan wajib diisi.',
            'pertemuan.integer'                => 'Pertemuan harus berupa angka.',
            'pertemuan.min'                    => 'Pertemuan minimal bernilai 1.',
            'pertemuan.unique'                 => 'Pertemuan untuk kelas ini sudah pernah diajukan.',
            'hari.required'                    => 'Hari wajib diisi.',
            'jam_mulai.required'               => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format'            => 'Format jam mulai harus HH:MM.',
            'jam_selesai.required'             => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format'          => 'Format jam selesai harus HH:MM.',
            'jam_selesai.after'                => 'Jam selesai harus lebih besar dari jam mulai.',
            'ruangan.required'                 => 'Ruangan wajib diisi.',
            'tanggal_ganti_kp.required'        => 'Tanggal ganti KP wajib diisi.',
            'tanggal_ganti_kp.date'            => 'Format tanggal ganti KP tidak valid.',
            'tanggal_pengganti.required'       => 'Tanggal pengganti wajib diisi.',
            'tanggal_pengganti.date'           => 'Format tanggal pengganti tidak valid.',
            'tanggal_pengganti.after_or_equal' => 'Tanggal pengganti harus sama atau setelah tanggal ganti KP.',
            'alasan.required'                  => 'Alasan wajib diisi.',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);

        KelasPengganti::create([
            'kelas_id'          => $kelas->id,
            'nama_kelas'        => $kelas->nama_kelas,
            'semester'          => $kelas->semester,
            'dosen'             => auth()->user()->name,
            'pertemuan'         => $request->pertemuan,
            'hari'              => $request->hari,
            'jam_mulai'         => $request->jam_mulai,
            'jam_selesai'       => $request->jam_selesai,
            'ruangan'           => $request->ruangan,
            'tanggal_ganti_kp'  => $request->tanggal_ganti_kp,
            'tanggal_pengganti' => $request->tanggal_pengganti,
            'alasan'            => $request->alasan,
            'status'            => 'pending',
        ]);

        return redirect()
            ->route('dosen.kelas_pengganti')
            ->with('success', 'Pengajuan kelas pengganti berhasil dikirim.');
    }

    public function dosenDestroy($id)
    {
        $kelasPengganti = KelasPengganti::where('id', $id)
            ->where('dosen', auth()->user()->name)
            ->firstOrFail();

        if ($kelasPengganti->status === 'approved') {
            return back()->with('error', 'Kelas pengganti yang sudah approved tidak dapat dihapus oleh dosen.');
        }

        DB::beginTransaction();

        try {
            AbsensiKelasPengganti::where('kelas_pengganti_id', $kelasPengganti->id)->delete();
            BapKelasPengganti::where('kelas_pengganti_id', $kelasPengganti->id)->delete();

            $kelasPengganti->delete();

            DB::commit();

            return back()->with('success', 'Pengajuan kelas pengganti berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus pengajuan kelas pengganti: ' . $e->getMessage());
        }
    }

    // ===================== ADMIN =====================

    public function adminIndex()
    {
        $kelasPengganti = KelasPengganti::orderByDesc('created_at')->get();

        return view('admin.kelas_pengganti.index', compact('kelasPengganti'));
    }

    public function approve($id)
    {
        $kelasPengganti = KelasPengganti::findOrFail($id);

        $kelasPengganti->update([
            'status' => 'approved',
        ]);

        return back()->with('success', 'Kelas pengganti disetujui.');
    }

    public function reject($id)
    {
        $kelasPengganti = KelasPengganti::findOrFail($id);

        $kelasPengganti->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Kelas pengganti ditolak.');
    }

    public function adminDestroy($id)
    {
        DB::beginTransaction();

        try {
            $kelasPengganti = KelasPengganti::findOrFail($id);

            AbsensiKelasPengganti::where('kelas_pengganti_id', $kelasPengganti->id)->delete();
            BapKelasPengganti::where('kelas_pengganti_id', $kelasPengganti->id)->delete();

            $kelasPengganti->delete();

            DB::commit();

            return back()->with('success', 'Data kelas pengganti berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus data kelas pengganti: ' . $e->getMessage());
        }
    }

    // ===================== MAHASISWA =====================

    public function mahasiswaIndex()
    {
        $mahasiswaId = auth()->id();

        $kelasIds = KelasMahasiswa::where('mahasiswa_id', $mahasiswaId)
            ->pluck('kelas_id');

        $kelasPengganti = KelasPengganti::whereIn('kelas_id', $kelasIds)
            ->where('status', 'approved')
            ->orderByDesc('tanggal_pengganti')
            ->get();

        $kelasMap = Kelas::with('mataKuliah')
            ->whereIn('id', $kelasPengganti->pluck('kelas_id')->unique())
            ->get()
            ->keyBy('id');

        $bapMap = BapKelasPengganti::whereIn('kelas_pengganti_id', $kelasPengganti->pluck('id'))
            ->get()
            ->keyBy('kelas_pengganti_id');

        $absensiMap = AbsensiKelasPengganti::whereIn('kelas_pengganti_id', $kelasPengganti->pluck('id'))
            ->where('mahasiswa_id', $mahasiswaId)
            ->get()
            ->keyBy('kelas_pengganti_id');

        $kelasPengganti->transform(function ($item) use ($kelasMap, $bapMap, $absensiMap) {
            $item->kelas_asli = $kelasMap->get($item->kelas_id);
            $item->bap_mahasiswa = $bapMap->get($item->id);
            $item->absensi_mahasiswa = $absensiMap->get($item->id);
            return $item;
        });

        return view('mahasiswa.kelas_pengganti.index', compact('kelasPengganti'));
    }

    public function mahasiswaDetail($id)
    {
        $mahasiswaId = auth()->id();

        $kelasPengganti = KelasPengganti::where('id', $id)
            ->where('status', 'approved')
            ->firstOrFail();

        $terdaftar = KelasMahasiswa::where('mahasiswa_id', $mahasiswaId)
            ->where('kelas_id', $kelasPengganti->kelas_id)
            ->exists();

        if (! $terdaftar) {
            return redirect()
                ->route('mahasiswa.kelas_pengganti')
                ->with('error', 'Kamu tidak terdaftar di kelas ini.');
        }

        $kelas = Kelas::with('mataKuliah')
            ->where('id', $kelasPengganti->kelas_id)
            ->first();

        $bap = BapKelasPengganti::where('kelas_pengganti_id', $kelasPengganti->id)->first();

        $absensi = AbsensiKelasPengganti::where('kelas_pengganti_id', $kelasPengganti->id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->first();

        return view('mahasiswa.kelas_pengganti.detail', compact(
            'kelasPengganti',
            'kelas',
            'bap',
            'absensi'
        ));
    }
}
