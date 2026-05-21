@extends('layouts.app')

@section('content')

<h1 class="page-title"><i class="fas fa-user-cog me-2"></i>Mi perfil</h1>

<div class="row g-4">
    <!-- Actualizar información -->
    <div class="col-12">
        <div class="card">
            <div class="card-header-custom">
                <i class="fas fa-user me-2"></i>Información personal
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <!-- Cambiar contraseña -->
    <div class="col-12">
        <div class="card">
            <div class="card-header-custom">
                <i class="fas fa-lock me-2"></i>Cambiar contraseña
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

    <!-- Eliminar cuenta (solo admin) -->
    @if(auth()->user()->role === 'admin')
    <div class="col-12">
        <div class="card">
            <div class="card-header-custom" style="background: linear-gradient(135deg, #7f1d1d, #dc2626);">
                <i class="fas fa-trash me-2"></i>Eliminar cuenta
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
    @endif
</div>

@endsection