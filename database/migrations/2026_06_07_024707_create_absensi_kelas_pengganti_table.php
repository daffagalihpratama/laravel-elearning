<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi_kelas_pengganti', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelas_pengganti_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alfa'])->default('Alfa');
            $table->timestamps();
            $table->foreign('kelas_pengganti_id')->references('id')->on('kelas_pengganti')->onDelete('cascade');
            $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['kelas_pengganti_id', 'mahasiswa_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('absensi_kelas_pengganti');
    }
};
