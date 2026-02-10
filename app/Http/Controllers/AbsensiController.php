<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Otp;
use App\Models\Holiday;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /* =========================
     * MODE TESTING
     * ========================= */
    private function testing()
    {
        return config('app.testing_absensi') === true;
    }

    /* =========================
     * FORM ABSENSI
     * ========================= */
    public function create()
    {
        return view('guru.absensi.create');
    }

    /* =========================
     * IZIN / SAKIT
     * ========================= */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:izin,sakit',
            'keterangan' => 'required|min:5|max:255',
            'lampiran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Lampiran foto
        ]);

        $now = Carbon::now();
        $startWindow = Carbon::today()->setTime(5, 30);
        $endWindow = Carbon::today()->setTime(16, 0);

        if (!$this->testing()) {
            if ($now->lt($startWindow)) {
                return back()->with('error', 'Pengajuan izin/sakit belum dibuka. Silakan kembali jam 05:30.');
            }
            if ($now->gt($endWindow)) {
                return back()->with('error', 'Batas waktu pengajuan izin/sakit sudah lewat (16:00).');
            }

            $holiday = Holiday::where('date', today())->first();
            if ($holiday) {
                return back()->with('error', 'Hari ini libur');
            }

            // Cek apakah sudah ada absensi hari ini
            $existingAbsensi = Absensi::where('user_id', Auth::id())
                ->whereDate('tanggal', today())
                ->first();

            // Jika sudah ada absensi dan bukan status bolos, reject
            if ($existingAbsensi && $existingAbsensi->status !== 'bolos') {
                return back()->with('error', 'Anda sudah absensi hari ini dengan status: ' . $existingAbsensi->status);
            }
        }

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran_absensi', 'public');
        }

        // Cek lagi apakah ada record bolos (untuk update)
        $existingAbsensi = Absensi::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->where('status', 'bolos')
            ->first();

        if ($existingAbsensi) {
            // Update record bolos menjadi pengajuan izin/sakit
            $existingAbsensi->update([
                'jam_datang' => $now->format('H:i:s'),
                'status' => $request->status,
                'keterangan' => $request->keterangan,
                'lampiran' => $lampiranPath,
                'is_valid' => false,
                'pending' => true,
            ]);

            // Buat notifikasi untuk guru
            Notification::create([
                'user_id' => Auth::id(),
                'type' => $request->status . '_pending',
                'title' => 'Pengajuan ' . ucfirst($request->status),
                'message' => 'Pengajuan ' . $request->status . ' Anda sedang menunggu persetujuan admin. Keterangan: ' . $request->keterangan,
                'related_absensi_id' => $existingAbsensi->id,
                'is_read' => false,
            ]);

            return back()->with('success', 'Pengajuan ' . $request->status . ' berhasil dikirim. Status bolos Anda akan diubah jika disetujui admin.');
        } else {
            // Buat record baru
            $newAbsensi = Absensi::create([
                'user_id' => Auth::id(),
                'tanggal' => today(),
                'jam_datang' => $now->format('H:i:s'),
                'status' => $request->status,
                'keterangan' => $request->keterangan,
                'lampiran' => $lampiranPath,
                'is_valid' => false,
                'pending' => true,
            ]);

            // Buat notifikasi untuk guru
            Notification::create([
                'user_id' => Auth::id(),
                'type' => $request->status . '_pending',
                'title' => 'Pengajuan ' . ucfirst($request->status),
                'message' => 'Pengajuan ' . $request->status . ' Anda sedang menunggu persetujuan admin. Keterangan: ' . $request->keterangan,
                'related_absensi_id' => $newAbsensi->id,
                'is_read' => false,
            ]);

            return back()->with('success', 'Pengajuan ' . $request->status . ' berhasil dikirim.');
        }
    }

    /* =========================
     * ABSEN DATANG
     * ========================= */
    /* =========================
     * ABSEN DATANG
     * ========================= */
    public function absenDatang(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $now = Carbon::now();
        
        // --- LOGIKA WAKTU (05:30 - 07:30) ---
        $startMasuk = Carbon::today()->setTime(5, 30);
        $limitRegular = Carbon::today()->setTime(7, 0);
        $maxMasuk = Carbon::today()->setTime(7, 30);

        if (!$this->testing()) {
            if ($now->lt($startMasuk)) {
                return back()->with('error', 'Absen masuk belum dibuka. Silakan kembali jam 05:30.');
            }
            if ($now->gt($maxMasuk)) {
                return back()->with('error', 'Batas waktu absen masuk sudah lewat (07:30). Anda dianggap tidak hadir.');
            }

            $holiday = Holiday::where('date', today())->first();
            if ($holiday) {
                return back()->with('error', 'Hari ini libur');
            }

            $sudah = Absensi::where('user_id', Auth::id())
                ->whereDate('tanggal', today())
                ->exists();

            if ($sudah) {
                return back()->with('error', 'Anda sudah melakukan absensi hari ini');
            }
        }

        /* 📍 VALIDASI LOKASI ASLI */
        $jarak = $this->hitungJarak(
            $request->latitude,
            $request->longitude,
            config('sekolah.latitude'),
            config('sekolah.longitude')
        );

        if ($jarak > config('sekolah.radius')) {
            return back()->with('error', 'Anda di luar area sekolah');
        }

        $menitTelat = null;
        $status = 'hadir';

        if ($now->gt($limitRegular)) {
            $menitTelat = $limitRegular->diffInMinutes($now);
        }

        $absen = Absensi::create([
            'user_id' => Auth::id(),
            'tanggal' => today(),
            'jam_datang' => $now->format('H:i:s'),
            'status' => $status,
            'menit_telat' => $menitTelat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'pending' => true,
            'is_valid' => false,
        ]);

        session(['pending_absensi_id' => $absen->id]);

        return $this->kirimOtp();
    }

    /* =========================
     * ABSEN PULANG
     * ========================= */
    public function absenPulang(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $now = Carbon::now();
        
        // --- LOGIKA WAKTU (12:00 - 16:00) ---
        $startPulang = Carbon::today()->setTime(12, 0);
        $maxPulang = Carbon::today()->setTime(16, 0);

        if (!$this->testing()) {
            if ($now->lt($startPulang)) {
                return back()->with('error', 'Absen pulang belum dibuka. Silakan kembali jam 12:00.');
            }
            if ($now->gt($maxPulang)) {
                return back()->with('error', 'Batas waktu absen pulang sudah lewat (16:00).');
            }
        }

        $absen = Absensi::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->whereNotNull('jam_datang')
            ->whereNull('jam_pulang')
            ->first();

        if (!$absen) {
            // Cek apakah memang tidak ada record atau recordnya berstatus lain
            $cekStatus = Absensi::where('user_id', Auth::id())->whereDate('tanggal', today())->first();
            if ($cekStatus) {
                if ($cekStatus->jam_pulang) {
                    return back()->with('error', 'Anda sudah melakukan absen pulang hari ini.');
                }
                return back()->with('error', 'Anda tidak bisa absen pulang karena status hari ini: ' . $cekStatus->status);
            }
            return back()->with('error', 'Anda tidak melakukan absen masuk pagi ini, akses absen pulang ditutup.');
        }

        /* 📍 VALIDASI LOKASI ASLI */
        $jarak = $this->hitungJarak(
            $request->latitude,
            $request->longitude,
            config('sekolah.latitude'),
            config('sekolah.longitude')
        );

        if ($jarak > config('sekolah.radius')) {
            return back()->with('error', 'Anda di luar area sekolah');
        }

        $absen->update([
            'jam_pulang' => $now->format('H:i:s'),
            'pending' => true,
            'is_valid' => false,
        ]);

        session(['pending_absensi_id' => $absen->id]);

        return $this->kirimOtp();
    }

    /* =========================
     * OTP
     * ========================= */
    public function showOtp()
    {
        $otp = Otp::where('user_id', Auth::id())->latest()->first();
        $otpExpiredAt = $otp ? $otp->expired_at->timestamp : 0;
        
        return view('absensi.otp', compact('otpExpiredAt'));
    }

    public function kirimOtp()
    {
        Otp::where('user_id', Auth::id())->delete();

        $kode = rand(100000, 999999);

        Otp::create([
            'user_id' => Auth::id(),
            'code' => $kode,
            'expired_at' => now()->addMinutes(5),
        ]);

        Mail::to(Auth::user()->email)->send(new OtpMail($kode));

        return redirect()->route('absensi.formOtp')
            ->with('success', 'OTP dikirim ke email');
    }

    public function verifikasiOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        $otp = Otp::where('user_id', Auth::id())
            ->where('code', $request->otp)
            ->where('expired_at', '>', now())
            ->first();

        if (!$otp) {
            return back()->with('error', 'OTP salah / kadaluarsa');
        }

        $absen = Absensi::find(session('pending_absensi_id'));

        if (!$absen) {
            return back()->with('error', 'Data absensi tidak ditemukan');
        }

        $absen->update([
            'pending' => false,
            'is_valid' => true,
        ]);

        Otp::where('user_id', Auth::id())->delete();
        session()->forget('pending_absensi_id');

        return redirect()->route('dashboard')
            ->with('success', 'Absensi berhasil');
    }

     /* =========================
     * AUTO BOLOS (CRON)
     * ========================= */
    public function autoTidakHadir()
    {
        $now = Carbon::now();

        if ($now->lt(today()->setTime(16, 0))) return;

        Absensi::whereDate('tanggal', today())
            ->whereNotNull('jam_datang')
            ->whereNull('jam_pulang')
            ->update([
                'status' => 'bolos',
            ]);
    }

    /* =========================
     * HITUNG JARAK
     * ========================= */
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earth = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2 +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon / 2) ** 2;

        return 2 * $earth * asin(sqrt($a));
    }


    public function riwayat(Request $request)
    {
        // Validate inputs if present
        $request->validate([
            'tanggal' => 'nullable|date',
            'sort' => 'nullable|in:asc,desc',
            'status' => 'nullable|string'
        ]);

        // Build query
        $query = Absensi::where('user_id', auth()->id());

        // Filter by date if provided
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply sorting (default: newest first)
        $sort = $request->get('sort', 'desc');
        $query->orderBy('tanggal', $sort)
            ->orderBy('created_at', $sort); // Secondary sort by creation time

        // Get results with pagination (15 items)
        $absensis = $query->paginate(15)->withQueryString();

        // Get holidays untuk ditampilkan di riwayat
        $holidays = \App\Models\Holiday::pluck('description', 'date')->toArray();

        return view('guru.absensi.riwayat', compact('absensis', 'holidays'));
    }

}
