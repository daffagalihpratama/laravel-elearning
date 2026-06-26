<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    protected $table = 'pengumpulan_tugas';

    protected $fillable = [
    'mahasiswa_id',
    'tugas_id',
    'link_jawaban',
    'nilai',
    'status'
];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
