<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {

    $table->id();

    $table->unsignedBigInteger('mahasiswa_id');

    $table->unsignedBigInteger('kelas_id');

    $table->integer('pertemuan_ke');

    $table->date('tanggal');

    $table->string('status');

    $table->timestamps();

});
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
