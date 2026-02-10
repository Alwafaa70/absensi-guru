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
        // Status 'bolos' sudah bisa digunakan karena kolom status 
        // sudah diubah menjadi string(20) di migration sebelumnya
        // (2026_01_27_035852_change_status_column_on_absensis.php)
        // 
        // Status yang tersedia:
        // - hadir
        // - telat
        // - izin
        // - sakit
        // - tidak_hadir
        // - bolos (NEW)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            //
        });
    }
};
