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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Guru yang menerima notifikasi
            $table->string('type'); // 'izin_pending', 'izin_approved', 'izin_rejected', 'sakit_pending', 'sakit_approved', 'sakit_rejected', 'holiday', 'broadcast'
            $table->string('title'); // Judul notifikasi
            $table->text('message'); // Isi pesan
            $table->string('image')->nullable(); // Path foto (opsional)
            $table->foreignId('related_absensi_id')->nullable()->constrained('absensis')->onDelete('cascade'); // ID absensi terkait (jika ada)
            $table->boolean('is_read')->default(false); // Status sudah dibaca atau belum
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
