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
    Schema::create('tugas', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('kelas_id');
        $table->unsignedBigInteger('dosen_id');

        $table->string('judul');
        $table->text('deskripsi');
        $table->date('deadline');

        $table->timestamps();

        // foreign key manual (lebih aman di Railway)
        $table->foreign('kelas_id')
            ->references('id')
            ->on('kelas')
            ->onDelete('cascade');

        $table->foreign('dosen_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
