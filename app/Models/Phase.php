<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $table = 'phases';

    protected $fillable = [
        'nivo_id',
        'naziv',
        'opis',
        'blocks',
        'rules',
        'solution',
        'hint',
        'order'
    ];

    protected $casts = [
        'blocks' => 'array',
        'rules' => 'array',
        'solution' => 'array',
    ];

    public function nivo()
    {
        return $this->belongsTo(Nivo::class);
    }
}
