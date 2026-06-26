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
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
    $table->id();

    $table->foreignId('mahasiswa_id')
          ->constrained('users')
          ->cascadeOnDelete();

    $table->foreignId('tugas_id')
          ->constrained('tugas')
          ->cascadeOnDelete();

    $table->text('link_jawaban')->nullable();

    $table->integer('nilai')->nullable();

    $table->string('status')
          ->default('Belum Dikerjakan');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_tugas');
    }
};
