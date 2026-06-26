<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas_pengganti', function (Blueprint $table) {
            $table->date('tanggal_ganti_kp')->nullable()->after('ruangan');
        });
    }

    public function down(): void
    {
        Schema::table('kelas_pengganti', function (Blueprint $table) {
            $table->dropColumn('tanggal_ganti_kp');
        });
    }
};
