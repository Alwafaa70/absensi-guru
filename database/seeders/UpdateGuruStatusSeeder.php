<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateGuruStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update semua guru yang belum punya status_kepegawaian
        $gurus = User::where('role', 'guru')->get();

        foreach ($gurus as $guru) {
            // Random status: 60% honor, 40% pns
            $status = (rand(1, 100) <= 60) ? 'honor' : 'pns';
            
            $guru->update([
                'status_kepegawaian' => $status
            ]);
            
            $this->command->info("Updated {$guru->name} - Status: " . strtoupper($status));
        }

        $this->command->info("\nTotal guru updated: " . $gurus->count());
        $pnsCount = User::where('role', 'guru')->where('status_kepegawaian', 'pns')->count();
        $honorCount = User::where('role', 'guru')->where('status_kepegawaian', 'honor')->count();
        $this->command->info("PNS: {$pnsCount} | Honor: {$honorCount}");
    }
}
