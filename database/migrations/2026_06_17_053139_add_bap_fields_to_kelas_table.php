<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->integer('bap_pertemuan')->nullable()->after('is_absen_open');
            $table->text('bap_rangkuman')->nullable()->after('bap_pertemuan');
            $table->string('bap_metode_pembelajaran')->nullable()->after('bap_rangkuman');
            $table->text('bap_berita_acara')->nullable()->after('bap_metode_pembelajaran');
            $table->timestamp('bap_diisi_pada')->nullable()->after('bap_berita_acara');
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn([
                'bap_pertemuan',
                'bap_rangkuman',
                'bap_metode_pembelajaran',
                'bap_berita_acara',
                'bap_diisi_pada',
            ]);
        });
    }
};
