<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BroadcastController extends Controller
{
    // Tampilkan form broadcast
    public function create()
    {
        return view('admin.broadcast.create');
    }

    // Kirim broadcast ke semua guru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Upload foto jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('broadcasts', 'public');
        }

        // Generate unique broadcast ID
        $broadcastId = 'broadcast_' . Str::uuid();

        // Ambil semua guru
        $gurus = User::where('role', 'guru')->get();

        // Buat notifikasi untuk setiap guru
        foreach ($gurus as $guru) {
            Notification::create([
                'user_id' => $guru->id,
                'type' => 'broadcast',
                'broadcast_id' => $broadcastId,
                'title' => $request->title,
                'message' => $request->message,
                'image' => $imagePath,
                'is_read' => false,
            ]);
        }

        return redirect()->route('admin.broadcast.index')
            ->with('success', "Pesan berhasil dikirim ke {$gurus->count()} guru!");
    }

    // Tampilkan riwayat broadcast
    public function index()
    {
        // Ambil broadcast unik berdasarkan broadcast_id
        $broadcasts = Notification::where('type', 'broadcast')
            ->whereNotNull('broadcast_id')
            ->select('broadcast_id', 'title', 'message', 'image', 'created_at')
            ->groupBy('broadcast_id', 'title', 'message', 'image', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.broadcast.index', compact('broadcasts'));
    }

    // Tampilkan form edit broadcast
    public function edit($broadcastId)
    {
        // Ambil salah satu notifikasi dari broadcast ini (untuk mendapatkan data)
        $broadcast = Notification::where('broadcast_id', $broadcastId)
            ->where('type', 'broadcast')
            ->firstOrFail();

        return view('admin.broadcast.edit', compact('broadcast'));
    }

    // Update broadcast
    public function update(Request $request, $broadcastId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil semua notifikasi dengan broadcast_id ini
        $notifications = Notification::where('broadcast_id', $broadcastId)
            ->where('type', 'broadcast')
            ->get();

        if ($notifications->isEmpty()) {
            return redirect()->route('admin.broadcast.index')
                ->with('error', 'Broadcast tidak ditemukan');
        }

        // Ambil image path lama
        $oldImagePath = $notifications->first()->image;

        // Upload foto baru jika ada
        $imagePath = $oldImagePath;
        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
            $imagePath = $request->file('image')->store('broadcasts', 'public');
        }

        // Update semua notifikasi dengan broadcast_id yang sama
        foreach ($notifications as $notification) {
            $notification->update([
                'title' => $request->title,
                'message' => $request->message,
                'image' => $imagePath,
            ]);
        }

        return redirect()->route('admin.broadcast.index')
            ->with('success', "Broadcast berhasil diperbarui untuk {$notifications->count()} guru!");
    }

    // Hapus broadcast
    public function destroy($broadcastId)
    {
        // Ambil semua notifikasi dengan broadcast_id ini
        $notifications = Notification::where('broadcast_id', $broadcastId)
            ->where('type', 'broadcast')
            ->get();

        if ($notifications->isEmpty()) {
            return redirect()->route('admin.broadcast.index')
                ->with('error', 'Broadcast tidak ditemukan');
        }

        // Ambil image path untuk dihapus
        $imagePath = $notifications->first()->image;

        // Hapus foto jika ada
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        // Hapus semua notifikasi
        $count = $notifications->count();
        Notification::where('broadcast_id', $broadcastId)
            ->where('type', 'broadcast')
            ->delete();

        return redirect()->route('admin.broadcast.index')
            ->with('success', "Broadcast berhasil dihapus dari {$count} guru!");
    }
}
