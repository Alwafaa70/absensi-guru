<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Absensi;
use Carbon\Carbon;

class HapusBolosSalah extends Command
{
    protected $signature = 'absensi:hapus-bolos-salah';
    protected $description = 'Hapus data bolos yang dibuat sebelum jam 07:30';

    public function handle()
    {
        $today = Carbon::today()->toDateString();
        
        // Hapus semua record bolos hari ini yang dibuat sebelum jam 07:30
        $deleted = Absensi::where('status', 'bolos')
            ->whereDate('tanggal', $today)
            ->whereTime('created_at', '<', '07:30:00')
            ->delete();

        $this->info("Berhasil menghapus {$deleted} record bolos yang salah.");
        
        return 0;
    }
}
