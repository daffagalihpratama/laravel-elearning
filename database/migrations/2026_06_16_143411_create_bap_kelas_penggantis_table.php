<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bap_kelas_pengganti', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelas_pengganti_id');
            $table->text('materi');
            $table->string('metode_pembelajaran')->nullable();
            $table->text('catatan_dosen')->nullable();
            $table->timestamps();

            $table->foreign('kelas_pengganti_id')
                ->references('id')
                ->on('kelas_pengganti')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bap_kelas_pengganti');
    }
};
