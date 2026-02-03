<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HTMLBlock extends Model
{
    use HasFactory;

    protected $fillable = ['naziv', 'kod'];

    public function nivos()
    {
        return $this->belongsToMany(
            Nivo::class,
            'nivo_h_t_m_l_blocks'
        );
    }
    public function nivoHTMLBlokovi()
{
    return $this->hasMany(NivoHTMLBlock::class);
}

}
