<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Biaya extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $fillable = [
        'type', 'cost'];

    
    public function kuitansi()
    {
        return $this->hasOne(Kuitansi::class);
    }
}
