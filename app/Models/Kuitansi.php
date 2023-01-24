<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kuitansi extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $fillable = [
        'kuitansi_number',
        'kuitansi_date',
        'cost_total',
        'perjadin_id',
        'biaya_id'
    ];

    public function perjadin()
    {
        return $this->belongsTo(Perjadin::class);
    }

    public function biaya()
    {
        return $this->belongsTo(Biaya::class);
    }
}
