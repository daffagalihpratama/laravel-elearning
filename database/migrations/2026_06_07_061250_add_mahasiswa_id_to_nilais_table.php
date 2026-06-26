<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->unsignedBigInteger('mahasiswa_id')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropColumn('mahasiswa_id');
        });
    }
};
