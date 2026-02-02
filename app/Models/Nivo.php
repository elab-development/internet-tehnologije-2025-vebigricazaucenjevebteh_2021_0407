<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivo extends Model
{
    use HasFactory;

    protected $fillable = ['naziv', 'opis', 'tezina','expected','hint','is_active',];

    public function pokusaji()
    {
        return $this->hasMany(Pokusaj::class);
    }

    public function nivoHTMLBlokovi()
    {
        return $this->hasMany(NivoHTMLBlock::class);
    }

    public function rezultati()
    {
        return $this->hasMany(Rezultat::class);
    }

}
