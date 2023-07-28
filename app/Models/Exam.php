<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'start_time',
        'end_time',
        'duration',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
