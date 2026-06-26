<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasPengganti extends Model
{
    protected $table = 'kelas_pengganti';

    protected $fillable = [
        'kelas_id',
        'pertemuan',
        'nama_kelas',
        'semester',
        'dosen',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'tanggal_ganti_kp',
        'tanggal_pengganti',
        'alasan',
        'status',
    ];

    protected $casts = [
        'kelas_id' => 'integer',
        'pertemuan' => 'integer',
        'tanggal_ganti_kp' => 'date',
        'tanggal_pengganti' => 'date',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function absensiMahasiswa()
    {
        return $this->hasMany(AbsensiKelasPengganti::class, 'kelas_pengganti_id');
    }

    public function bap()
    {
        return $this->hasOne(BapKelasPengganti::class, 'kelas_pengganti_id');
    }
}
