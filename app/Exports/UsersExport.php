<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Email',
            'Rol',
            'Código Concesión',
            'Ubicación',
            'Departamento',
            'Puesto',
        ];
    }

    public function collection()
    {
        $query = User::with([
            'perfilEmpleado.codigoConcesionario.ubicacion',
            'perfilEmpleado.departamento',
            'perfilEmpleado.puesto',
        ]);

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($this->request->filled('codigo_concesionario_id')) {
            $query->whereHas('perfilEmpleado', function ($q) {
                $q->where('codigo_concesionario_id', $this->request->codigo_concesionario_id);
            });
        }

        if ($this->request->filled('departamento_id')) {
            $query->whereHas('perfilEmpleado', function ($q) {
                $q->where('departamento_id', $this->request->departamento_id);
            });
        }

        if ($this->request->filled('puesto_id')) {
            $query->whereHas('perfilEmpleado', function ($q) {
                $q->where('puesto_id', $this->request->puesto_id);
            });
        }

        return $query->get()->map(function ($user) {
            return [
                $user->name,
                $user->email,
                $user->role,
                $user->perfilEmpleado?->codigoConcesionario?->codigo ?? '-',
                $user->perfilEmpleado?->codigoConcesionario?->ubicacion?->nombre ?? '-',
                $user->perfilEmpleado?->departamento?->nombre ?? '-',
                $user->perfilEmpleado?->puesto?->nombre ?? '-',
            ];
        });
    }
}