<?php

use App\Models\Absensi;
use Carbon\Carbon;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$today = Carbon::today()->toDateString();

echo "\n========================================\n";
echo "Cek Data Auto-Bolos Hari Ini\n";
echo "========================================\n";
echo "Tanggal: $today\n\n";

$bolos = Absensi::whereDate('tanggal', $today)
    ->where('status', 'bolos')
    ->with('user:id,name')
    ->get();

if ($bolos->count() > 0) {
    echo "Total guru yang bolos: " . $bolos->count() . "\n\n";
    
    foreach ($bolos as $absensi) {
        echo "✓ " . $absensi->user->name . "\n";
        echo "  Status: " . $absensi->status . "\n";
        echo "  Keterangan: " . ($absensi->keterangan ?? '-') . "\n\n";
    }
} else {
    echo "Tidak ada data bolos hari ini.\n";
    echo "\nKemungkinan:\n";
    echo "1. Semua guru sudah absen\n";
    echo "2. Hari ini adalah hari libur/weekend\n";
    echo "3. Command auto-bolos belum dijalankan\n\n";
    echo "Jalankan: php artisan absensi:auto-bolos datang --force\n";
}

echo "========================================\n\n";
