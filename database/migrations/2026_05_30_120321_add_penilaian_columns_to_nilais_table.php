<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilais', function (Blueprint $table) {

            if (!Schema::hasColumn('nilais', 'nilai_tugas')) {
                $table->integer('nilai_tugas')->default(0);
            }

            if (!Schema::hasColumn('nilais', 'nilai_uts')) {
                $table->integer('nilai_uts')->default(0);
            }

            if (!Schema::hasColumn('nilais', 'nilai_uas')) {
                $table->integer('nilai_uas')->default(0);
            }

            if (!Schema::hasColumn('nilais', 'nilai_akhir')) {
                $table->decimal('nilai_akhir', 5, 2)->default(0);
            }

            // grade TIDAK dibuat karena sudah ada
        });
    }

    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {

            $columns = [];

            if (Schema::hasColumn('nilais', 'nilai_tugas')) {
                $columns[] = 'nilai_tugas';
            }

            if (Schema::hasColumn('nilais', 'nilai_uts')) {
                $columns[] = 'nilai_uts';
            }

            if (Schema::hasColumn('nilais', 'nilai_uas')) {
                $columns[] = 'nilai_uas';
            }

            if (Schema::hasColumn('nilais', 'nilai_akhir')) {
                $columns[] = 'nilai_akhir';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
