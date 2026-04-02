<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',       // presencial, e-learning, virtual
        'start_date',
        'end_date',
    ];

    /**
     * Relación: asignaciones de este curso
     */
    public function assignments()
    {
        return $this->hasMany(CourseAssignment::class);
    }

    public function calls()
    {
    return $this->hasMany(CourseCall::class);
    }

}
