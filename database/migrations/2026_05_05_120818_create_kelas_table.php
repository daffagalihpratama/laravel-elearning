<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // pastikan tabel ada dulu biar tidak crash di production
        if (Schema::hasTable('kelas')) {
            Schema::table('kelas', function (Blueprint $table) {
                // cek juga biar tidak error kalau column sudah ada
                if (!Schema::hasColumn('kelas', 'deadline_input_nilai')) {
                    $table->dateTime('deadline_input_nilai')
                        ->nullable()
                        ->after('status');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('kelas')) {
            Schema::table('kelas', function (Blueprint $table) {
                if (Schema::hasColumn('kelas', 'deadline_input_nilai')) {
                    $table->dropColumn('deadline_input_nilai');
                }
            });
        }
    }
};
