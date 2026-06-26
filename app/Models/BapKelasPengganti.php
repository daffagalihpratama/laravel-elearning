<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BapKelasPengganti extends Model
{
    protected $table = 'bap_kelas_pengganti';

    protected $fillable = [
        'kelas_pengganti_id',
        'materi',
        'metode_pembelajaran',
        'catatan_dosen',
    ];

    public function kelasPengganti()
    {
        return $this->belongsTo(KelasPengganti::class, 'kelas_pengganti_id');
    }
}
