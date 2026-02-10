<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Holiday;
use Carbon\Carbon;

class AutoMarkBolos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absensi:auto-bolos {type : datang atau pulang} {--force : Paksa jalankan tanpa cek waktu}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis menandai guru sebagai bolos jika tidak absen';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        $today = Carbon::now('Asia/Jakarta');
        $tanggal = $today->toDateString();
        $currentTime = $today->format('H:i');

        // Validasi waktu (kecuali jika menggunakan --force)
        if (!$this->option('force')) {
            if ($type === 'datang' && $currentTime < '07:30') {
                $this->error("❌ Command ini hanya bisa dijalankan setelah jam 07:30!");
                $this->info("💡 Gunakan flag --force jika ingin paksa jalankan untuk testing.");
                return 1;
            }

            if ($type === 'pulang' && $currentTime < '16:00') {
                $this->error("❌ Command ini hanya bisa dijalankan setelah jam 16:00!");
                $this->info("💡 Gunakan flag --force jika ingin paksa jalankan untuk testing.");
                return 1;
            }
        } else {
            $this->warn("⚠️  Mode FORCE aktif - validasi waktu di-skip!");
        }

        // Cek apakah hari ini adalah hari libur
        if ($this->isHoliday($tanggal)) {
            $this->info("Hari ini adalah hari libur. Tidak ada auto-bolos.");
            return 0;
        }

        // Cek apakah hari ini adalah Sabtu atau Minggu
        if ($today->isSaturday() || $today->isSunday()) {
            $this->info("Hari ini adalah akhir pekan. Tidak ada auto-bolos.");
            return 0;
        }

        if ($type === 'datang') {
            $this->markBolosDatang($tanggal);
        } elseif ($type === 'pulang') {
            $this->markBolosPulang($tanggal);
        } else {
            $this->error("Type harus 'datang' atau 'pulang'");
            return 1;
        }

        return 0;
    }

    /**
     * Mark guru sebagai bolos jika tidak absen datang sampai jam 07:30
     */
    private function markBolosDatang($tanggal)
    {
        $guru = User::where('role', 'guru')->get();
        $count = 0;

        foreach ($guru as $g) {
            // Cek apakah guru sudah punya record absensi hari ini
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
                $count++;
                $this->info("✓ {$g->name} ditandai bolos (tidak absen datang)");
            }
        }

        $this->info("Total {$count} guru ditandai bolos karena tidak absen datang.");
    }

    /**
     * Mark guru sebagai bolos jika sudah absen datang tapi tidak absen pulang sampai jam 16:00
     */
    private function markBolosPulang($tanggal)
    {
        // Cari semua absensi yang:
        // 1. Tanggal hari ini
        // 2. Sudah absen datang (jam_datang tidak null)
        // 3. Belum absen pulang (jam_pulang null)
        // 4. Status bukan izin/sakit (karena izin/sakit tidak perlu absen pulang)
        $absensis = Absensi::whereDate('tanggal', $tanggal)
            ->whereNotNull('jam_datang')
            ->whereNull('jam_pulang')
            ->whereNotIn('status', ['izin', 'sakit', 'bolos'])
            ->get();

        $count = 0;

        foreach ($absensis as $absensi) {
            $absensi->update([
                'status' => 'bolos',
                'keterangan' => ($absensi->keterangan ? $absensi->keterangan . ' | ' : '') . 'Otomatis ditandai bolos karena tidak absen pulang sampai jam 16:00'
            ]);
            $count++;
            $this->info("✓ {$absensi->user->name} ditandai bolos (tidak absen pulang)");
        }

        $this->info("Total {$count} guru ditandai bolos karena tidak absen pulang.");
    }

    /**
     * Cek apakah tanggal tertentu adalah hari libur
     */
    private function isHoliday($tanggal)
    {
        return Holiday::where('date', $tanggal)->exists();
    }
}
