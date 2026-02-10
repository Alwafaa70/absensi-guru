<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'broadcast_id',
        'title',
        'message',
        'image',
        'related_absensi_id',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Relationship ke User (Guru)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship ke Absensi (jika ada)
    public function absensi()
    {
        return $this->belongsTo(Absensi::class, 'related_absensi_id');
    }

    // Scope untuk notifikasi belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope untuk notifikasi sudah dibaca
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    // Mark as read
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}
