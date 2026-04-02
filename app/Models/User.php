<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar en masa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // agregamos role
        'dni',
        'dealer_code',
        'active',
    ];

    /**
     * Los atributos que deben ocultarse al serializar.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben tener un cast especial.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación: cursos asignados al usuario
     */
    public function assignments()
    {
        return $this->hasMany(CourseAssignment::class);
    }

    public function perfilEmpleado()
    {
    return $this->hasOne(PerfilEmpleado::class);
    }


   
}
