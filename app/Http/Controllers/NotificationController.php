<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Tampilkan semua notifikasi untuk guru yang login
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = Notification::where('user_id', auth()->id())
            ->unread()
            ->count();

        return view('guru.notifications.index', compact('notifications', 'unreadCount'));
    }

    // Mark notifikasi sebagai sudah dibaca
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->markAsRead();

        return back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }

    // Mark semua notifikasi sebagai sudah dibaca
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->unread()
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }

    // Hapus notifikasi
    public function destroy($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus');
    }

    // Get unread count untuk badge
    public function getUnreadCount()
    {
        $count = Notification::where('user_id', auth()->id())
            ->unread()
            ->count();

        return response()->json(['count' => $count]);
    }
}
