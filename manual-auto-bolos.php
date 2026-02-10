<?php

use App\Models\User;
use App\Models\Absensi;
use App\Models\Holiday;
use Carbon\Carbon;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$tanggal = '2026-02-09'; // Senin, 9 Februari 2026

echo "\n========================================\n";
echo "Manual Auto-Bolos untuk $tanggal\n";
echo "========================================\n\n";

// Cek apakah hari libur
$isHoliday = Holiday::where('date', $tanggal)->exists();
if ($isHoliday) {
    echo "❌ Tanggal $tanggal adalah hari libur. Tidak ada auto-bolos.\n\n";
    exit;
}

// Cek apakah weekend
$carbon = Carbon::parse($tanggal);
if ($carbon->isSaturday() || $carbon->isSunday()) {
    echo "❌ Tanggal $tanggal adalah weekend. Tidak ada auto-bolos.\n\n";
    exit;
}

echo "✓ Tanggal $tanggal adalah hari kerja (" . $carbon->translatedFormat('l') . ")\n\n";

// 1. AUTO-BOLOS DATANG
echo "--- AUTO-BOLOS DATANG ---\n";
$guru = User::where('role', 'guru')->get();
$countDatang = 0;

foreach ($guru as $g) {
    $absensi = Absensi::where('user_id', $g->id)
        ->where('tanggal', $tanggal)
        ->first();

    if (!$absensi) {
        // Belum ada record sama sekali, buat record baru dengan status bolos
        Absensi::create([
            'user_id' => $g->id,
            'tanggal' => $tanggal,
            'status' => 'bolos',
            'is_valid' => true,
            'pending' => false,
            'keterangan' => 'Otomatis ditandai bolos karena tidak absen datang sampai jam 07:30'
        ]);
        $countDatang++;
        echo "✓ {$g->name} ditandai bolos (tidak absen datang)\n";
    }
}

echo "Total {$countDatang} guru ditandai bolos karena tidak absen datang.\n\n";

// 2. AUTO-BOLOS PULANG
echo "--- AUTO-BOLOS PULANG ---\n";
$absensis = Absensi::whereDate('tanggal', $tanggal)
    ->whereNotNull('jam_datang')
    ->whereNull('jam_pulang')
    ->whereNotIn('status', ['izin', 'sakit', 'bolos'])
    ->get();

$countPulang = 0;

foreach ($absensis as $absensi) {
    $absensi->update([
        'status' => 'bolos',
        'keterangan' => ($absensi->keterangan ? $absensi->keterangan . ' | ' : '') . 'Otomatis ditandai bolos karena tidak absen pulang sampai jam 16:00'
    ]);
    $countPulang++;
    echo "✓ {$absensi->user->name} ditandai bolos (tidak absen pulang)\n";
}

echo "Total {$countPulang} guru ditandai bolos karena tidak absen pulang.\n\n";

echo "========================================\n";
echo "SELESAI!\n";
echo "Total: " . ($countDatang + $countPulang) . " guru ditandai bolos\n";
echo "========================================\n\n";
