<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
protected $fillable = [
    'user_id',
    'tanggal',
    'jam_datang',
    'jam_pulang',
    'status',
    'menit_telat',
    'keterangan',
    'latitude',
    'longitude',
    'is_valid',
    'pending',
    'lampiran'
];


   public function user()
    {
        return $this->belongsTo(User::class);
    }
}
