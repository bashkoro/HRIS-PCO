<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HakKeuangan extends Model
{
    protected $fillable = [
        'user_id',
        'slip_gaji',
        'periode',
        'status',
        'hak_keuangan',
        'pph_21',
        'iuran_bpjs',
        'penghasilan_bersih'
    ];

    protected $casts = [
        'hak_keuangan' => 'decimal:2',
        'pph_21' => 'decimal:2',
        'iuran_bpjs' => 'decimal:2',
        'penghasilan_bersih' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedHakKeuanganAttribute()
    {
        return 'Rp ' . number_format($this->hak_keuangan, 0, ',', '.');
    }

    public function getFormattedPph21Attribute()
    {
        return 'Rp ' . number_format($this->pph_21, 0, ',', '.');
    }

    public function getFormattedIuranBpjsAttribute()
    {
        return 'Rp ' . number_format($this->iuran_bpjs, 0, ',', '.');
    }

    public function getFormattedPenghasilanBersihAttribute()
    {
        return 'Rp ' . number_format($this->penghasilan_bersih, 0, ',', '.');
    }
}
