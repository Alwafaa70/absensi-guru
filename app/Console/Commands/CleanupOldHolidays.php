<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Holiday;
use Carbon\Carbon;

class CleanupOldHolidays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holidays:cleanup {--force : Paksa jalankan tanpa konfirmasi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus hari libur yang sudah lewat untuk mengurangi beban sistem';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now('Asia/Jakarta')->toDateString();
        
        // Cari hari libur yang sudah lewat (tanggal < hari ini)
        $oldHolidays = Holiday::where('date', '<', $today)->get();
        
        if ($oldHolidays->isEmpty()) {
            $this->info("✓ Tidak ada hari libur yang perlu dihapus.");
            return 0;
        }
        
        $count = $oldHolidays->count();
        
        $this->info("Ditemukan {$count} hari libur yang sudah lewat:");
        $this->newLine();
        
        foreach ($oldHolidays as $holiday) {
            $this->line("  - " . Carbon::parse($holiday->date)->translatedFormat('d F Y') . " ({$holiday->description})");
        }
        
        $this->newLine();
        
        // Konfirmasi jika tidak menggunakan --force
        if (!$this->option('force')) {
            if (!$this->confirm('Apakah Anda yakin ingin menghapus hari libur yang sudah lewat?', true)) {
                $this->warn('Operasi dibatalkan.');
                return 0;
            }
        }
        
        // Hapus hari libur yang sudah lewat
        Holiday::where('date', '<', $today)->delete();
        
        $this->newLine();
        $this->info("✓ Berhasil menghapus {$count} hari libur yang sudah lewat.");
        $this->info("✓ Sistem menjadi lebih ringan!");
        
        return 0;
    }
}
