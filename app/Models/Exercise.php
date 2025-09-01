<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'block_id',
        'name',
        'reps',
        'weight',
        'notes',
        'display_order',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }
}
