<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeNilai extends Model
{
    use HasFactory;

    protected $table = 'periode_nilais';

    protected $fillable = [
        'mulai_input',
        'deadline_input',
        'is_active',
    ];

    protected $casts = [
        'mulai_input' => 'datetime',
        'deadline_input' => 'datetime',
        'is_active' => 'boolean',
    ];
}
