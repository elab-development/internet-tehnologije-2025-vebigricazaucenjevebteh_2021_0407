<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rezultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'pokusaj_id',
        'bodovi',
        'uspesno'
    ];

    public function pokusaj()
    {
        return $this->belongsTo(Pokusaj::class);
    }
}
