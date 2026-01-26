<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivo extends Model
{
    use HasFactory;

    protected $fillable = ['naziv', 'opis', 'tezina'];

    public function pokusaji()
    {
        return $this->hasMany(Pokusaj::class);
    }

    public function htmlBlokovi()
    {
        return $this->belongsToMany(
            HTMLBlock::class,
            'nivo_h_t_m_l_blocks'
        );
    }
}
