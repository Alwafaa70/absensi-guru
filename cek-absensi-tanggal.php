<?php

use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$tanggal = '2026-02-09';

echo "\n========================================\n";
echo "Cek Data Absensi untuk $tanggal\n";
echo "========================================\n\n";

$guru = User::where('role', 'guru')->get();

echo "Total Guru: " . $guru->count() . "\n\n";

foreach ($guru as $g) {
    echo "Guru: {$g->name}\n";
    
    $absensi = Absensi::where('user_id', $g->id)
        ->where('tanggal', $tanggal)
        ->first();
    
    if ($absensi) {
        echo "  ✓ Ada record absensi\n";
        echo "  - Status: {$absensi->status}\n";
        echo "  - Jam Datang: " . ($absensi->jam_datang ?? '-') . "\n";
        echo "  - Jam Pulang: " . ($absensi->jam_pulang ?? '-') . "\n";
        echo "  - Keterangan: " . ($absensi->keterangan ?? '-') . "\n";
    } else {
        echo "  ❌ TIDAK ADA record absensi (SEHARUSNYA BOLOS!)\n";
    }
    echo "\n";
}

echo "========================================\n\n";
