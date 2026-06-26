<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiKelasPenggantiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dosen\MateriController;
use App\Http\Controllers\DosenDashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KelasPenggantiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\Admin\PeriodeNilaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Buttons;

/*
|--------------------------------------------------------------------------
| MAIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // USER
    Route::resource('users', UserController::class);

    // KELAS
    Route::resource('kelas', KelasController::class);
    Route::post('kelas/{id}/approve', [KelasController::class, 'approve'])->name('kelas.approve');
    Route::post('kelas/{id}/reject', [KelasController::class, 'reject'])->name('kelas.reject');

    // MATA KULIAH
    Route::resource('matakuliah', MataKuliahController::class);

    // NILAI
    Route::resource('nilai', NilaiController::class)->except(['show']);

    // PERIODE NILAI
    // PERIODE NILAI
Route::get('periode-nilai', [PeriodeNilaiController::class, 'index'])
    ->name('admin.periode-nilai.index');

Route::get('periode-nilai/create', [PeriodeNilaiController::class, 'create'])
    ->name('admin.periode-nilai.create');

Route::post('periode-nilai/store', [PeriodeNilaiController::class, 'store'])
    ->name('admin.periode-nilai.store');

Route::get('periode-nilai/{id}/edit', [PeriodeNilaiController::class, 'edit'])
    ->name('admin.periode-nilai.edit');

Route::put('periode-nilai/{id}', [PeriodeNilaiController::class, 'update'])
    ->name('admin.periode-nilai.update');

Route::delete('periode-nilai/{id}', [PeriodeNilaiController::class, 'destroy'])
    ->name('admin.periode-nilai.destroy');

    // TUGAS READ ONLY
    Route::get('tugas', [TugasController::class, 'adminIndex'])->name('admin.tugas');
    Route::get('tugas/{id}', [TugasController::class, 'adminDetail'])->name('admin.tugas.detail');

    // KELAS PENGGANTI
    Route::get('kelas-pengganti', [KelasPenggantiController::class, 'adminIndex'])->name('admin.kelas_pengganti');
    Route::post('kelas-pengganti/{id}/approve', [KelasPenggantiController::class, 'approve'])->name('admin.kelas_pengganti.approve');
    Route::post('kelas-pengganti/{id}/reject', [KelasPenggantiController::class, 'reject'])->name('admin.kelas_pengganti.reject');
    Route::delete('kelas-pengganti/{id}', [KelasPenggantiController::class, 'adminDestroy'])->name('admin.kelas_pengganti.destroy');

    // KELOLA MAHASISWA DALAM KELAS
    Route::get('kelas-mahasiswa', [AbsensiKelasPenggantiController::class, 'adminKelasList'])->name('admin.kelas_mahasiswa');
    Route::get('kelas-mahasiswa/{kelasId}', [AbsensiKelasPenggantiController::class, 'adminKelasMahasiswa'])->name('admin.kelas_mahasiswa.show');
    Route::post('kelas-mahasiswa/{kelasId}/tambah', [AbsensiKelasPenggantiController::class, 'adminTambahMahasiswa'])->name('admin.kelas_mahasiswa.tambah');
    Route::delete('kelas-mahasiswa/{kelasId}/hapus/{mahasiswaId}', [AbsensiKelasPenggantiController::class, 'adminHapusMahasiswa'])->name('admin.kelas_mahasiswa.hapus');
});

/*
|--------------------------------------------------------------------------
| DOSEN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->group(function () {
    Route::get('/', [DosenDashboardController::class, 'index'])->name('dosen.dashboard');

    // KELAS UTAMA
    Route::get('kelas', [KelasController::class, 'dosenIndex'])->name('dosen.kelas');
    Route::get('kelas/create', [KelasController::class, 'createDosen'])->name('dosen.kelas.create');
    Route::post('kelas/store', [KelasController::class, 'storeDosen'])->name('dosen.kelas.store');

    // BAP KELAS UTAMA
    Route::post('absensi/{kelasId}/bap', [AbsensiController::class, 'dosenSimpanBap'])->name('dosen.absensi.bap.store');

    // KELOLA MAHASISWA KELAS UTAMA
    Route::post('kelas/{kelasId}/mahasiswa/tambah', [AbsensiController::class, 'dosenTambahMahasiswa'])->name('dosen.kelas.mahasiswa.tambah');
    Route::delete('kelas/{kelasId}/mahasiswa/{mahasiswaId}/hapus', [AbsensiController::class, 'dosenHapusMahasiswa'])->name('dosen.kelas.mahasiswa.hapus');

    // MATERI
    Route::get('materi', [MateriController::class, 'index'])->name('dosen.materi');
    Route::get('materi/create', [MateriController::class, 'create'])->name('dosen.materi.create');
    Route::post('materi/store', [MateriController::class, 'store'])->name('dosen.materi.store');

    // TUGAS
    Route::get('tugas', [TugasController::class, 'index'])->name('dosen.tugas');
    Route::get('tugas/create', [TugasController::class, 'create'])->name('dosen.tugas.create');
    Route::post('tugas', [TugasController::class, 'store'])->name('dosen.tugas.store');
    Route::get('tugas/{id}/edit', [TugasController::class, 'edit'])->name('dosen.tugas.edit');
    Route::put('tugas/{id}', [TugasController::class, 'update'])->name('dosen.tugas.update');
    Route::delete('tugas/{id}', [TugasController::class, 'destroy'])->name('dosen.tugas.destroy');

    // PENGUMPULAN DAN NILAI TUGAS
    Route::get('tugas/{id}/pengumpulan', [TugasController::class, 'pengumpulan'])->name('dosen.tugas.pengumpulan');
    Route::post('pengumpulan/{id}/nilai', [TugasController::class, 'simpanNilai'])->name('dosen.tugas.nilai');

    // KELAS PENGGANTI
    Route::get('kelas-pengganti', [KelasPenggantiController::class, 'dosenIndex'])->name('dosen.kelas_pengganti');
    Route::get('kelas-pengganti/create', [KelasPenggantiController::class, 'dosenCreate'])->name('dosen.kelas_pengganti.create');
    Route::post('kelas-pengganti/store', [KelasPenggantiController::class, 'dosenStore'])->name('dosen.kelas_pengganti.store');
    Route::delete('kelas-pengganti/{id}', [KelasPenggantiController::class, 'dosenDestroy'])->name('dosen.kelas_pengganti.destroy');

    // BAP KELAS PENGGANTI
    Route::post('kelas-pengganti/{id}/bap', [AbsensiKelasPenggantiController::class, 'dosenSimpanBap'])->name('dosen.kelas_pengganti.bap.store');

    // ABSENSI KELAS UTAMA
    Route::get('absensi/{id}/buka', [AbsensiController::class, 'dosenBukaAbsensi'])->name('dosen.absensi.buka');
    Route::get('absensi/{id}/tutup', [AbsensiController::class, 'dosenTutupAbsensi'])->name('dosen.absensi.tutup');
    Route::get('absensi/{id}/detail', [AbsensiController::class, 'dosenDetail'])->name('dosen.absensi.detail');
    Route::post('absensi/{kelasId}/update-manual', [AbsensiController::class, 'dosenUpdateAbsensiManual'])->name('dosen.absensi.update_manual');
    Route::get('absensi/{kelasId}/edit-mahasiswa/{mahasiswaId}', [AbsensiController::class, 'dosenEditMahasiswa'])->name('dosen.absensi.edit-mahasiswa');
    Route::delete('absensi/{kelasId}/hapus-mahasiswa/{mahasiswaId}', [AbsensiController::class, 'dosenHapusMahasiswaAbsensi'])->name('dosen.absensi.hapus-mahasiswa');
    Route::post('absensi/{kelasId}/update-mahasiswa/{mahasiswaId}', [AbsensiController::class, 'dosenUpdateMahasiswaAbsensi'])->name('dosen.absensi.update-mahasiswa');

    // ABSENSI KELAS PENGGANTI
    Route::get('kelas-pengganti/{id}/absensi', [AbsensiKelasPenggantiController::class, 'dosenBukaAbsensi'])->name('dosen.kelas_pengganti.absensi');
    Route::put('kelas-pengganti/absensi/{id}', [AbsensiKelasPenggantiController::class, 'dosenUpdateAbsensi'])->name('dosen.kelas_pengganti.absensi.update');

    // MAHASISWA
    Route::get('mahasiswa', [MahasiswaController::class, 'dosenIndex'])->name('dosen.mahasiswa');

    // NILAI
    Route::get('nilai', [NilaiController::class, 'dosenIndex'])->name('dosen.nilai');
    Route::get('nilai/create', [NilaiController::class, 'dosenCreate'])->name('dosen.nilai.create');
    Route::post('nilai', [NilaiController::class, 'dosenStore'])->name('dosen.nilai.store');
    Route::get('nilai/{id}/edit', [NilaiController::class, 'dosenEdit'])->name('dosen.nilai.edit');
    Route::put('nilai/{id}', [NilaiController::class, 'dosenUpdate'])->name('dosen.nilai.update');
    Route::delete('nilai/{id}', [NilaiController::class, 'dosenDestroy'])->name('dosen.nilai.destroy');
});

/*
|--------------------------------------------------------------------------
| MAHASISWA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('mahasiswa', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');

    // PROFIL
    Route::get('mahasiswa/profil', [MahasiswaController::class, 'profil'])->name('mahasiswa.profil');

    // KELAS UTAMA
    Route::get('mahasiswa/kelas', [KelasController::class, 'mahasiswaIndex'])->name('mahasiswa.kelas');
    Route::get('mahasiswa/kelas/{id}/detail', [KelasController::class, 'mahasiswaDetail'])->name('mahasiswa.kelas.detail');

    // KELAS PENGGANTI
    Route::get('mahasiswa/kelas-pengganti', [KelasPenggantiController::class, 'mahasiswaIndex'])->name('mahasiswa.kelas_pengganti');
    Route::get('mahasiswa/kelas-pengganti/{id}/detail', [KelasPenggantiController::class, 'mahasiswaDetail'])->name('mahasiswa.kelas_pengganti.detail');
    Route::post('mahasiswa/kelas-pengganti/{id}/absen', [AbsensiKelasPenggantiController::class, 'mahasiswaAbsen'])->name('mahasiswa.kelas_pengganti.absen');

    // MATERI
    Route::get('mahasiswa/materi', [MahasiswaController::class, 'materi'])->name('mahasiswa.materi');

    // TUGAS
    Route::get('mahasiswa/tugas', [TugasController::class, 'mahasiswaIndex'])->name('mahasiswa.tugas');
    Route::post('mahasiswa/tugas/{id}/submit', [TugasController::class, 'submit'])->name('mahasiswa.tugas.submit');

    // ABSENSI KELAS UTAMA
    Route::get('mahasiswa/absensi', [AbsensiController::class, 'index'])->name('mahasiswa.absensi');
    Route::post('mahasiswa/absen', [AbsensiController::class, 'store'])->name('absensi.store');

    // NILAI
    Route::get('mahasiswa/nilai', [MahasiswaController::class, 'nilai'])->name('mahasiswa.nilai');
});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('update-photo', [ProfileController::class, 'updatePhoto'])->name('update.photo');
});

/*
|--------------------------------------------------------------------------
| UI TEMPLATE
|--------------------------------------------------------------------------
*/
Route::get('layouts/without-menu', [WithoutMenu::class, 'index']);
Route::get('layouts/without-navbar', [WithoutNavbar::class, 'index']);
Route::get('layouts/fluid', [Fluid::class, 'index']);
Route::get('layouts/container', [Container::class, 'index']);
Route::get('layouts/blank', [Blank::class, 'index']);

Route::get('pages/account-settings-account', [AccountSettingsAccount::class, 'index']);
Route::get('pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index']);
Route::get('pages/account-settings-connections', [AccountSettingsConnections::class, 'index']);
Route::get('pages/misc-error', [MiscError::class, 'index']);
Route::get('pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index']);

Route::get('ui/accordion', [Accordion::class, 'index']);
Route::get('ui/alerts', [Alerts::class, 'index']);
Route::get('ui/buttons', [Buttons::class, 'index']);
Route::get('ui/cards', [CardBasic::class, 'index']);
