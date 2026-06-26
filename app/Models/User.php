<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\PengumpulanTugas;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'photo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * 🔥 RELASI KE PENGUMPULAN TUGAS
     * 1 mahasiswa bisa punya banyak pengumpulan
     */
    public function pengumpulans()
    {
        return $this->hasMany(PengumpulanTugas::class, 'mahasiswa_id');
    }

    /**
     * 🔥 HELPER FOTO PROFILE
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('uploads/' . $this->photo);
        }

        return asset('assets/img/avatars/1.png');
    }
}
