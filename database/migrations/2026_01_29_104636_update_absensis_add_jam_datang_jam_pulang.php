<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            // TAMBAH KOLOM BARU
            $table->time('jam_datang')->nullable()->after('tanggal');
            $table->time('jam_pulang')->nullable()->after('jam_datang');

            // KOLOM LAMA TIDAK DIPAKAI LAGI
            if (Schema::hasColumn('absensis', 'waktu')) {
                $table->dropColumn('waktu');
            }
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn(['jam_datang', 'jam_pulang']);
            $table->timestamp('waktu')->nullable();
        });
    }
};

