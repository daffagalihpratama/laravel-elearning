<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kelas;

class MataKuliah extends Model
{
    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
        'kode_dosen',
        'dosen_pengampu'
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'mata_kuliah_id');
    }
}
