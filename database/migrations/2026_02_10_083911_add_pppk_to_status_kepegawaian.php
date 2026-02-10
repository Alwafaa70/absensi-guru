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
        Schema::table('users', function (Blueprint $table) {
            // Ubah enum status_kepegawaian untuk menambahkan 'pppk'
            \DB::statement("ALTER TABLE users MODIFY COLUMN status_kepegawaian ENUM('pns', 'pppk', 'honor') DEFAULT 'honor'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan ke enum semula (hanya pns dan honor)
            \DB::statement("ALTER TABLE users MODIFY COLUMN status_kepegawaian ENUM('pns', 'honor') DEFAULT 'honor'");
        });
    }
};
