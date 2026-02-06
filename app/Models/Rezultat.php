<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rezultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'korisnik_id',
        'nivo_id',
        'phase_id',
        'poeni',
    ];
}

