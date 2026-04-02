<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = User::with([
            'perfilEmpleado.codigoConcesionario.ubicacion',
            'perfilEmpleado.departamento',
            'perfilEmpleado.puesto',
        ]);

        // 🔍 Búsqueda
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 🏬 Concesionario
        if ($this->request->filled('codigo_concesionario_id')) {
            $query->whereHas('perfilEmpleado', function ($q) {
                $q->where('codigo_concesionario_id', $this->request->codigo_concesionario_id);
            });
        }

        // 🏢 Departamento
        if ($this->request->filled('departamento_id')) {
            $query->whereHas('perfilEmpleado', function ($q) {
                $q->where('departamento_id', $this->request->departamento_id);
            });
        }

        // 🧑‍🔧 Puesto
        if ($this->request->filled('puesto_id')) {
            $query->whereHas('perfilEmpleado', function ($q) {
                $q->where('puesto_id', $this->request->puesto_id);
            });
        }

        return view('exports.users', [
            'users' => $query->get()
        ]);
    }
}
