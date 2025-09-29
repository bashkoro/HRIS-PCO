<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiPotongPajak extends Model
{
    protected $fillable = [
        'user_id',
        'periode',
        'file_path',
        'keterangan',
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedPeriodeAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m', $this->periode)->format('F Y');
    }
}
