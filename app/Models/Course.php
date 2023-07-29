<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'type',
        'time_period',
        'teacher_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class);
    }


    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }


    public function students()
    {
        return $this->belongsToMany(Student::class)->as('subscription')
        ->withTimestamps();
    }

    public function codesRequests()
    {
        return $this->hasMany(CodesRequest::class);
    }
}
