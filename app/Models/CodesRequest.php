<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodesRequest extends Model
{
    use HasFactory;

    public $fillable = [
        'course_id',
        'number_required',
        'code_type',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
