<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivoHTMLBlock extends Model
{
    use HasFactory;

    protected $table = 'nivo_h_t_m_l_blocks';

    protected $fillable = [
        'nivo_id',
        'html_block_id',
        'obaveznost',
        'redosled'
    ];

    public function nivo()
    {
        return $this->belongsTo(Nivo::class);
    }

    public function htmlBlock()
    {
        return $this->belongsTo(HTMLBlock::class);
    }
}
