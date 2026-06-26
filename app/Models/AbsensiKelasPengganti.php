<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\KelasPengganti;

class AbsensiKelasPengganti extends Model
{
    protected $table = 'absensi_kelas_pengganti';

    protected $fillable = [
        'kelas_pengganti_id',
        'mahasiswa_id',
        'status',
    ];

    public function kelasPengganti()
    {
        return $this->belongsTo(KelasPengganti::class, 'kelas_pengganti_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
