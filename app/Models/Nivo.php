<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivo extends Model
{
    use HasFactory;

    protected $table = 'nivos';

    protected $fillable = [
        'naziv',
        'opis',
        'tezina',
        'expected',
        'level_config',
        'hint',
        'is_active',
    ];

    protected $casts = [
        'expected' => 'array',
        'level_config' => 'array',
        'is_active' => 'boolean',
    ];

    public function phases()
    {
        return $this->hasMany(Phase::class, 'nivo_id')
                    ->orderBy('order');
    }

    public function rezultati()
    {
        return $this->hasMany(Rezultat::class);
    }
}
