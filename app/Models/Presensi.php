<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'user_id',
        'tanggal',
        'waktu_masuk',
        'waktu_pulang',
        'is_late',
        'is_early_leave',
        'location_lat',
        'location_lng',
        'is_outside_office',
        'office_building',
        'total_jam_kerja',
        'keterangan',
        'photo_masuk',
        'photo_pulang',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'is_late' => 'boolean',
            'is_early_leave' => 'boolean',
            'is_outside_office' => 'boolean',
            'location_lat' => 'decimal:8',
            'location_lng' => 'decimal:8',
            'total_jam_kerja' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
