<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuitansi extends Model
{
    use HasFactory;



    public function perjadin()
    {
        return $this->hasOne(Perjadin::class);
    }

    public function surat()
    {
        return $this->hasOne(Surat::class);
    }
}
