<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MataKuliah;
use App\Models\Materi;
use App\Models\KelasPengganti;
use App\Models\KelasMahasiswa;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'mata_kuliah_id',
        'nama_kelas',
        'semester',
        'dosen',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'status',
        'is_absen_open',
        'deadline_input_nilai',
    ];

    protected $casts = [
        'deadline_input_nilai' => 'datetime',
    ];

    public function kelasMahasiswa()
    {
        return $this->hasMany(KelasMahasiswa::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    public function kelasPengganti()
    {
        return $this->hasMany(KelasPengganti::class);
    }

    public function isDeadlineNilaiLewat(): bool
    {
        return $this->deadline_input_nilai && now()->gt($this->deadline_input_nilai);
    }
}
