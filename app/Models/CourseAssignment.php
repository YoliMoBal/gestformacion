<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_call_id',
        'status', // pending, in_progress, completed
    ];

    /**
     * Relación: usuario asignado
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Convocatoria asignada
     */
    public function courseCall()
    {
        return $this->belongsTo(\App\Models\CourseCall::class);
    }
}
