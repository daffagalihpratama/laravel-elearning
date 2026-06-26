<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas_pengganti', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->string('nama_kelas');
            $table->string('semester');
            $table->string('dosen');
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruangan')->nullable();
            $table->date('tanggal_pengganti');
            $table->text('alasan');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas_pengganti');
    }
};