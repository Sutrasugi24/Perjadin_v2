<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_date',
        'document_number',
        'perjadin_id'];

    
    public function perjadin()
    {
        return $this->belongsTo(Perjadin::class);
    }
}
