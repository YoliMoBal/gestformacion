<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoConcesionario extends Model
{
    protected $table = 'codigos_concesionario';

    protected $fillable = ['codigo', 'ubicacion_id'];

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    public function perfilesEmpleado()
    {
        return $this->hasMany(PerfilEmpleado::class);
    }
}
