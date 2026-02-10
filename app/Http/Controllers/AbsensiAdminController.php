<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with('user');

        // 🔍 Filter tanggal (harian)
        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // 🔍 Search nama guru
        if ($request->nama) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->nama . '%');
            });
        }

        // 🔍 Filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // 🔍 Sorting
        $sortOrder = $request->sort === 'oldest' ? 'asc' : 'desc';

        $absensis = $query
            ->orderBy('tanggal', $sortOrder)
            ->orderBy('jam_datang', $sortOrder)
            ->paginate(15)
            ->withQueryString();

        // Get holidays untuk ditampilkan di kelola absensi
        $holidays = \App\Models\Holiday::pluck('description', 'date')->toArray();

        return view('admin.absensi.index', compact('absensis', 'holidays'));
    }

    public function show($id)
    {
        $absensi = Absensi::with('user')->findOrFail($id);
        return view('admin.absensi.show', compact('absensi'));
    }

    public function edit($id)
    {
        $absensi = Absensi::with('user')->findOrFail($id);
        return view('admin.absensi.edit', compact('absensi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,bolos',
            'jam_datang' => 'nullable|date_format:H:i:s',
            'jam_pulang' => 'nullable|date_format:H:i:s',
            'menit_telat' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string|max:200',
        ]);

        $absensi = Absensi::findOrFail($id);

        // LOGIKA FIELD DINAMIS
        $menitTelat = null;
        $keterangan = null;
        
        // Simpan nilai input atau default null
        $menitTelat = $request->menit_telat; 
        $keterangan = $request->keterangan;

        // Reset logika jika status tertentu (Optional, tapi biarkan admin punya kontrol penuh sekarang)
        if ($request->status === 'telat') {
             // Pastikan menit telat diisi jika status telat?
             // Biarkan null jika admin tidak isi
        } elseif (in_array($request->status, ['izin', 'sakit'])) {
             // Keterangan wajib?
        } else {
             // Status hadir, bisa jadi menit telat 0
        }

        $absensi->update([
            'status' => $request->status,
            'jam_datang' => $request->jam_datang,
            'jam_pulang' => $request->jam_pulang,
            'menit_telat' => $request->menit_telat,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil diperbarui');
    }

    public function approve($id)
    {
        $absensi = Absensi::findOrFail($id);
        $oldStatus = $absensi->status;
        
        $absensi->update([
            'is_valid' => true,
            'pending' => false,
        ]);

        // Buat notifikasi untuk guru
        Notification::create([
            'user_id' => $absensi->user_id,
            'type' => $oldStatus . '_approved',
            'title' => 'Pengajuan ' . ucfirst($oldStatus) . ' Disetujui',
            'message' => 'Pengajuan ' . $oldStatus . ' Anda untuk tanggal ' . \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') . ' telah disetujui oleh admin.',
            'related_absensi_id' => $absensi->id,
            'is_read' => false,
        ]);

        return back()->with('success', 'Pengajuan ' . $oldStatus . ' berhasil disetujui.');
    }

    public function reject($id)
    {
        $absensi = Absensi::findOrFail($id);
        $oldStatus = $absensi->status;
        
        $absensi->update([
            'status' => 'bolos',
            'is_valid' => true,
            'pending' => false,
        ]);

        // Buat notifikasi untuk guru
        Notification::create([
            'user_id' => $absensi->user_id,
            'type' => $oldStatus . '_rejected',
            'title' => 'Pengajuan ' . ucfirst($oldStatus) . ' Ditolak',
            'message' => 'Pengajuan ' . $oldStatus . ' Anda untuk tanggal ' . \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') . ' telah ditolak oleh admin. Status diubah menjadi bolos.',
            'related_absensi_id' => $absensi->id,
            'is_read' => false,
        ]);

        return back()->with('success', 'Pengajuan ' . $oldStatus . ' telah ditolak dan diubah menjadi bolos.');
    }
}
