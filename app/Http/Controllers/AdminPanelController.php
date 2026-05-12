<?php

namespace App\Http\Controllers;

use App\Models\CourseAssignment;
use App\Models\User;
use App\Models\Ubicacion;
use App\Models\Departamento;
use App\Models\PerfilEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminPanelController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user_id;
        $status = $request->status;
        $search = $request->search;

        // 🔴 Caducados — ya pasó la fecha y siguen sin completar
        $expiredAssignments = CourseAssignment::with(['user', 'courseCall.course'])
            ->where('status', '!=', 'completed')
            ->whereHas('courseCall', function ($q) {
                $q->whereDate('end_date', '<', now());
            })
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when($search, fn($q) => $q->whereHas('user', fn($q2) =>
            $q2->where('name', 'like', "%{$search}%")))
            ->get();

        // ⚠️ Próximos a caducar — vencen en los próximos 7 días
        $pendingAssignments = CourseAssignment::with(['user', 'courseCall.course'])
            ->where('status', '!=', 'completed')
            ->whereHas('courseCall', function ($q) {
                $q->whereDate('end_date', '>=', now())
                    ->whereDate('end_date', '<=', now()->addDays(7));
            })
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when($search, fn($q) => $q->whereHas('user', fn($q2) =>
            $q2->where('name', 'like', "%{$search}%")))
            ->get();

        // ✅ Completados
        $completedAssignments = CourseAssignment::with(['user', 'courseCall.course'])
            ->where('status', 'completed')
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when($search, fn($q) => $q->whereHas('user', fn($q2) =>
            $q2->where('name', 'like', "%{$search}%")))
            ->orderByDesc('updated_at')
            ->get();

        $users = User::where('role', 'employee')
            ->where('active', true)
            ->orderBy('name')
            ->get();

        return view('admin.panel', compact(
            'pendingAssignments',
            'expiredAssignments',
            'completedAssignments',
            'users'
        ));
    }

    // ===============================
    // 🧾 FORMULARIO ALTA EMPLEADO
    // ===============================

    public function createEmpleado()
    {
        return view('admin.empleados.create', [
            'ubicaciones' => Ubicacion::with('codigosConcesionario')->get(),
            'departamentos' => Departamento::with('puestos')->get(),
        ]);
    }

    public function storeEmpleado(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'dni' => 'required|string|unique:users',
            'password' => 'required|min:6',
            'codigo_concesionario_id' => 'required|exists:codigos_concesionario,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'puesto_id' => 'required|exists:puestos,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dni' => $request->dni,
            'password' => Hash::make($request->password),
            'active' => true,
        ]);

        PerfilEmpleado::create([
            'user_id' => $user->id,
            'codigo_concesionario_id' => $request->codigo_concesionario_id,
            'departamento_id' => $request->departamento_id,
            'puesto_id' => $request->puesto_id,
        ]);

        return redirect()
            ->route('admin.empleados.create')
            ->with('success', 'Empleado creado correctamente');
    }
}
