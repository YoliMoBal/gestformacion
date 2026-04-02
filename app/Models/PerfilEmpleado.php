<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilEmpleado extends Model
{
    protected $table = 'perfiles_empleado';

    protected $fillable = [
        'user_id',
        'codigo_concesionario_id',
        'departamento_id',
        'puesto_id',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function codigoConcesionario()
    {
        return $this->belongsTo(CodigoConcesionario::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }
}

