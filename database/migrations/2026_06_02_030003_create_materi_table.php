<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('materi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('dosen_id');

            $table->string('judul');
            $table->integer('pertemuan');
            $table->text('deskripsi')->nullable();
            $table->string('file')->nullable();

            $table->timestamps();

            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->foreign('dosen_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
