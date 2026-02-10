<?php

use App\Models\User;
use App\Models\Absensi;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n========================================\n";
echo "Daftar Semua User\n";
echo "========================================\n\n";

$users = User::all();

foreach ($users as $user) {
    echo "ID: {$user->id}\n";
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role}\n";
    
    if ($user->role === 'guru') {
        $count = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', '2026-02-09')
            ->count();
        echo "Absensi 9 Feb: {$count} record\n";
    }
    
    echo "\n";
}

echo "========================================\n\n";

echo "Untuk login sebagai guru, gunakan salah satu email di atas.\n";
echo "Jika Anda login sebagai admin, Anda tidak akan melihat data di riwayat absensi guru.\n\n";
