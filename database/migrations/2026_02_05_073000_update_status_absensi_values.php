<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update semua record dengan status 'tidak_hadir' menjadi 'bolos'
        DB::table('absensis')
            ->where('status', 'tidak_hadir')
            ->update(['status' => 'bolos']);
        
        // Update semua record dengan status 'telat' menjadi 'hadir'
        // Karena telat bukan status, tapi hanya peringatan di kolom menit_telat
        DB::table('absensis')
            ->where('status', 'telat')
            ->update(['status' => 'hadir']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: kembalikan 'bolos' menjadi 'tidak_hadir'
        DB::table('absensis')
            ->where('status', 'bolos')
            ->update(['status' => 'tidak_hadir']);
        
        // Rollback: kembalikan 'hadir' yang memiliki menit_telat > 0 menjadi 'telat'
        DB::table('absensis')
            ->where('status', 'hadir')
            ->where('menit_telat', '>', 0)
            ->update(['status' => 'telat']);
    }
};
