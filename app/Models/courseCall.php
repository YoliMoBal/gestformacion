<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'start_date',
        'end_date',
        'notify_days_before',
        'notify_on_start',
        'notify_on_end',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function assignments()
    {
    return $this->hasMany(\App\Models\CourseAssignment::class);
    }

}
