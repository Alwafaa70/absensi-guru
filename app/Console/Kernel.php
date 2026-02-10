<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // 1️⃣ AUTO BOLOS JIKA TIDAK ABSEN DATANG SAMPAI JAM 07:30
        // Dijalankan setiap hari jam 07:31 (1 menit setelah batas waktu)
        $schedule->command('absensi:auto-bolos datang')
            ->dailyAt('07:31')
            ->timezone('Asia/Jakarta')
            ->runInBackground();

        // 2️⃣ AUTO BOLOS JIKA TIDAK ABSEN PULANG SAMPAI JAM 16:00
        // Dijalankan setiap hari jam 16:01 (1 menit setelah batas waktu)
        $schedule->command('absensi:auto-bolos pulang')
            ->dailyAt('16:01')
            ->timezone('Asia/Jakarta')
            ->runInBackground();

        // 3️⃣ AUTO HAPUS HARI LIBUR YANG SUDAH LEWAT
        // Dijalankan setiap hari jam 00:01 (tengah malam)
        $schedule->command('holidays:cleanup --force')
            ->dailyAt('00:01')
            ->timezone('Asia/Jakarta')
            ->runInBackground();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
