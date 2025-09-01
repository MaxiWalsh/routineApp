<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'display_order',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}
