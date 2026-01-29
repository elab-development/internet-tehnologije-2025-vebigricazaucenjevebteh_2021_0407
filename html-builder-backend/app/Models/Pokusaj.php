<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokusaj extends Model
{
    use HasFactory;

    protected $fillable = [
        'korisnik_id',
        'nivo_id',
        'vreme'
    ];

    public function korisnik()
    {
        return $this->belongsTo(Korisnik::class);
    }

    public function nivo()
    {
        return $this->belongsTo(Nivo::class);
    }

    public function rezultat()
    {
        return $this->hasOne(Rezultat::class);
    }
}
