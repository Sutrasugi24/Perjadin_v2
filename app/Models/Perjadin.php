<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perjadin extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'leave_date', 'return_date', 'plan',
        'destination', 'description', 'transport',
        'coordinator', 'user_id'];


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_perjadin', 'user_id', 'perjadin_id');
    }
}
