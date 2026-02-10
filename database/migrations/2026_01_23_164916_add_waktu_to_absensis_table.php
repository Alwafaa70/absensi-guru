<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('absensis', function (Blueprint $table) {
        if (!Schema::hasColumn('absensis', 'waktu')) {
            $table->time('waktu')->nullable()->after('tanggal');
        }
    });
}

public function down()
{
    Schema::table('absensis', function (Blueprint $table) {
        $table->dropColumn('waktu');
    });
}
};