<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use PDF; // nanti pakai barryvdh/laravel-dompdf

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        // Default Filtering (Bulan ini jika tidak ada filter)
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate   = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        // Ambil Data Absensi dalam Range
        $absensis = Absensi::with('user')
            ->whereBetween('tanggal', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();

        // Hitung Jumlah Hari Kerja (Senin - Jumat) dalam Range
        $totalDays = 0;
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {
            if ($date->isWeekday()) {
                $totalDays++;
            }
        }
        // Cegah division by zero
        if ($totalDays == 0) $totalDays = 1;

        // Ambil Data Guru
        $guruList = User::where('role', 'guru')->get();
        $statistik = [];

        foreach ($guruList as $guru) {
            // Filter absensi milik guru ini
            $absenGuru = $absensis->where('user_id', $guru->id);

            // Hitung Status berdasarkan kolom status
            $hadir = $absenGuru->where('status', 'hadir')->count();
            $izin = $absenGuru->where('status', 'izin')->count();
            $sakit = $absenGuru->where('status', 'sakit')->count();
            
            // Hitung Menit Telat (Total)
            $menitTelat = $absenGuru->whereNotNull('menit_telat')->sum('menit_telat');

            // Total presensi yang valid (hadir + izin + sakit)
            $totalPresensi = $hadir + $izin + $sakit;
            
            // Bolos: Total hari kerja - total presensi valid
            $bolos = max(0, $totalDays - $totalPresensi);

            // Persentase Kehadiran (Hadir + Izin + Sakit)
            $persentaseHadir = round(($totalPresensi / $totalDays) * 100, 1);
            
            // Persentase Bolos
            $persentaseBolos = round(($bolos / $totalDays) * 100, 1);

            $statistik[$guru->id] = [
                'guru' => $guru->name,
                'nip' => $guru->nip,
                'hadir' => $hadir,
                'bolos' => $bolos,
                'izin' => $izin,
                'sakit' => $sakit,
                'menit_telat' => $menitTelat,
                'persentase' => $persentaseHadir,
                'persentase_bolos' => $persentaseBolos
            ];
        }

        return view('admin.statistik.index', compact('statistik', 'startDate', 'endDate'));
    }

    public function grafik(Request $request) {
        // Reuse logic calculation if possible or re-implement
        // Untuk grafik kita butuh data yang sama
        // Call index internally or refactor logic. For now, copy-paste logic for simplicity in this context or redirect.
        // Better: refactor logic to private method.
        
        $data = $this->calculateStatistik($request);
        return view('admin.statistik.grafik', [
            'statistik' => $data['statistik'],
            'startDate' => $data['startDate'],
            'endDate' => $data['endDate']
        ]);
    }

    private function calculateStatistik($request) {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate   = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $absensis = Absensi::with('user')
            ->whereBetween('tanggal', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();

        $totalDays = 0;
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {
            if ($date->isWeekday()) {
                $totalDays++;
            }
        }
        if ($totalDays == 0) $totalDays = 1;

        $guruList = User::where('role', 'guru')->get();
        $statistik = [];

        foreach ($guruList as $guru) {
            $absenGuru = $absensis->where('user_id', $guru->id);

            // Hitung Status berdasarkan kolom status
            $hadir = $absenGuru->where('status', 'hadir')->count();

            $izin = $absenGuru->where('status', 'izin')->count();
            $sakit = $absenGuru->where('status', 'sakit')->count();
            $menitTelat = $absenGuru->whereNotNull('menit_telat')->sum('menit_telat');

            $totalPresensi = $hadir + $izin + $sakit;
            $bolos = max(0, $totalDays - $totalPresensi);
            
            $persentaseHadir = round(($totalPresensi / $totalDays) * 100, 1);
            $persentaseBolos = round(($bolos / $totalDays) * 100, 1);

            $statistik[] = [
                'name' => $guru->name,
                'nip' => $guru->nip,
                'hadir' => $hadir,
                'bolos' => $bolos,
                'izin' => $izin,
                'sakit' => $sakit,
                'persentase' => $persentaseHadir,
                'persentase_bolos' => $persentaseBolos,
                'menit_telat' => $menitTelat
            ];
        }
        return compact('statistik', 'startDate', 'endDate');
    }

    public function cetak(Request $request)
    {
        $data = $this->calculateStatistik($request);
        $pdf = PDF::loadView('admin.statistik.cetak', $data);
        return $pdf->stream('statistik_absensi.pdf');
    }
}
