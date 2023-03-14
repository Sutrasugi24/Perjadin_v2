<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Perjadin extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    protected $fillable = [
        'leave_date', 'return_date', 'plan',
        'destination', 'destination_two', 'destination_three', 'description', 'transport',
        'coordinator'];


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_perjadin', 'perjadin_id', 'user_id');
    }

    public function surat()
    {
        return $this->hasOne(Surat::class);
    }

    public function kuitansi()
    {
        return $this->hasOne(Kuitansi::class);
    }
}
