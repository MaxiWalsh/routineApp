<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_id',
        'name',
        'type',
        'display_order',
    ];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }
}
