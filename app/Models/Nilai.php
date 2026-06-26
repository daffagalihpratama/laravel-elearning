<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Nilai extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'mahasiswa',      // <-- tambahkan ini
        'kelas',
        'mata_kuliah',

        'nilai_tugas',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'semester',

        'grade',
        'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
