<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Korisnik extends Authenticatable
{
    use HasFactory;

    protected $table = 'korisniks';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
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
