<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Korisnik extends Authenticatable
{
    use HasApiTokens, HasFactory,Notifiable;

    protected $table = 'korisniks';

    protected $fillable = [
        'ime',
        'email',
        'password',
        'tip_korisnika'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function pokusaji()
    {
        return $this->hasMany(Pokusaj::class);
    }

    public function rezultati()
    {
        return $this->hasMany(Rezultat::class);
    }
}
