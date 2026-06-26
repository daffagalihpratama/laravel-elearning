<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PengumpulanTugas;
use App\Models\Kelas;
use App\Models\User;

class Tugas extends Model
{
    protected $table = 'tugas';

    protected $fillable = [
        'kelas_id',
        'dosen_id',
        'judul',
        'deskripsi',
        'deadline',
        'lampiran'
    ];

    // 🔗 Tugas milik kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // 🔗 Tugas dibuat oleh dosen
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    // 🔗 1 tugas punya banyak pengumpulan
    public function pengumpulans()
    {
        return $this->hasMany(PengumpulanTugas::class, 'tugas_id');
    }
}
