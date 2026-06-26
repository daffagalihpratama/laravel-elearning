<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->timestamps();

            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['kelas_id', 'mahasiswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas_mahasiswa');
    }
};
