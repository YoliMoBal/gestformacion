<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        $tipo = $request->input('tipo');

        if ($tipo === 'admin' && $user->role !== 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login', ['tipo' => 'admin'])
                ->withErrors(['email' => 'Esta sección es solo para administradores.']);
        }

        if ($tipo === 'employee' && $user->role !== 'employee' && $user->role !== 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login', ['tipo' => 'employee'])
                ->withErrors(['email' => 'Esta sección es solo para empleados.']);
        }

        // Si entra por acceso empleado, siempre va al dashboard
        if ($tipo === 'employee') {
            return redirect(route('dashboard'));
        }

        // Si es admin y entra por acceso admin, va al panel
        if ($user->role === 'admin') {
            return redirect(route('admin.panel'));
        }

        return redirect(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}