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
        'title',
        'task_text',
        'palette',
        'slots',
        'rules',
        'hint',
        'success',
        'order'
    ];

    protected $casts = [
        'palette' => 'array',
        'slots'   => 'array',
        'rules'   => 'array',
    ];

    public function nivo()
    {
        return $this->belongsTo(Nivo::class);
    }
}
