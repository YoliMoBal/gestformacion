<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Models\PerfilEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with([
            'perfilEmpleado.codigoConcesionario.ubicacion',
            'perfilEmpleado.departamento',
            'perfilEmpleado.puesto',
        ]);

        // 🔎 Búsqueda por nombre o email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 🏬 Filtro por concesionario
        if ($request->filled('codigo_concesionario_id')) {
            $query->whereHas('perfilEmpleado', function ($q) use ($request) {
                $q->where('codigo_concesionario_id', $request->codigo_concesionario_id);
            });
        }

        // 🏢 Filtro por departamento
        if ($request->filled('departamento_id')) {
            $query->whereHas('perfilEmpleado', function ($q) use ($request) {
                $q->where('departamento_id', $request->departamento_id);
            });
        }

        // 🧑‍🔧 Filtro por puesto
        if ($request->filled('puesto_id')) {
            $query->whereHas('perfilEmpleado', function ($q) use ($request) {
                $q->where('puesto_id', $request->puesto_id);
            });
        }


        // 📄 Paginación (mantiene filtros)
        $users = $query->paginate(10)->withQueryString();

        // Datos para los filtros
        $concesionarios = \App\Models\CodigoConcesionario::with('ubicacion')->get();
        $departamentos  = \App\Models\Departamento::orderBy('nombre')->get();
        $puestos = \App\Models\Puesto::orderBy('nombre')->get();


        return view('admin.users.index', compact(
            'users',
            'concesionarios',
            'departamentos',
            'puestos'
        ));
    }
    public function create()
    {
        $ubicaciones = \App\Models\Ubicacion::with('codigosConcesionario')->get();
        $departamentos = \App\Models\Departamento::orderBy('nombre')->get();
        $puestos = \App\Models\Puesto::orderBy('nombre')->get();

        return view('admin.users.create', compact('ubicaciones', 'departamentos', 'puestos'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'dni' => 'required|string|unique:users',
            'role' => 'required|in:admin,employee',
            'password' => 'required|string|min:6',

            'codigo_concesionario_id' => 'nullable|exists:codigos_concesionario,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'puesto_id' => 'nullable|exists:puestos,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dni' => $request->dni,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'active' => true,
        ]);

        PerfilEmpleado::updateOrCreate(
            ['user_id' => $user->id],
            [
                'codigo_concesionario_id' => $request->codigo_concesionario_id,
                'departamento_id' => $request->departamento_id,
                'puesto_id' => $request->puesto_id,
            ]
        );

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function edit(string $id)
    {
        $user = User::with('perfilEmpleado')->findOrFail($id);

        return view('admin.users.edit', [
            'user' => $user,
            'perfil' => $user->perfilEmpleado,
            'ubicaciones' => Ubicacion::with('codigosConcesionario')->get(),
            'departamentos' => Departamento::with('puestos')->get(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,employee',

            'codigo_concesionario_id' => 'nullable|exists:codigos_concesionario,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'puesto_id' => 'nullable|exists:puestos,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        PerfilEmpleado::updateOrCreate(
            ['user_id' => $user->id],
            [
                'codigo_concesionario_id' => $request->codigo_concesionario_id,
                'departamento_id' => $request->departamento_id,
                'puesto_id' => $request->puesto_id,
            ]
        );

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario eliminado correctamente');
    }

    public function toggleActive(string $id)
    {
        $user = User::findOrFail($id);
        $user->update(['active' => !$user->active]);

        $estado = $user->active ? 'activado' : 'desactivado';

        return redirect()
            ->route('users.index')
            ->with('success', "Usuario {$estado} correctamente");
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new UsersExport($request),
            'usuarios.xlsx'
        );
    }


    public function exportCsv(Request $request)
    {
        $query = User::with([
            'perfilEmpleado.codigoConcesionario.ubicacion',
            'perfilEmpleado.departamento',
            'perfilEmpleado.puesto',
        ]);

        // 🔍 Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 🏬 Concesionario
        if ($request->filled('codigo_concesionario_id')) {
            $query->whereHas('perfilEmpleado', function ($q) use ($request) {
                $q->where('codigo_concesionario_id', $request->codigo_concesionario_id);
            });
        }

        // 🏢 Departamento
        if ($request->filled('departamento_id')) {
            $query->whereHas('perfilEmpleado', function ($q) use ($request) {
                $q->where('departamento_id', $request->departamento_id);
            });
        }

        // 🧑‍🔧 Puesto
        if ($request->filled('puesto_id')) {
            $query->whereHas('perfilEmpleado', function ($q) use ($request) {
                $q->where('puesto_id', $request->puesto_id);
            });
        }

        $users = $query->get();

        $filename = 'usuarios_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            // BOM para Excel (acentos)
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Cabecera CSV
            fputcsv($file, [
                'Nombre',
                'Email',
                'Rol',
                'Código concesión',
                'Ubicación',
                'Departamento',
                'Puesto',
            ], ';');

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->perfilEmpleado?->codigoConcesionario?->codigo ?? '',
                    $user->perfilEmpleado?->codigoConcesionario?->ubicacion?->nombre ?? '',
                    $user->perfilEmpleado?->departamento?->nombre ?? '',
                    $user->perfilEmpleado?->puesto?->nombre ?? '',
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
