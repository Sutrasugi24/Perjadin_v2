<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Surat extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $fillable = 
        [
        'document_date',
        'document_number',
        'perjadin_id'];

    
    public function perjadin()
    {
        return $this->belongsTo(Perjadin::class);
    }

    public function kuitansi()
    {
        return $this->belongsTo(Kuitansi::class);
    }
}
