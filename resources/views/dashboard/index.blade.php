@extends('layouts.app')

@section('content')

<h1 class="page-title"><i class="fas fa-book-open me-2"></i>Mis cursos</h1>

@if($pendingAssignments->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
            <h4 class="mt-3 text-success">¡Enhorabuena!</h4>
            <p class="text-muted">No tienes cursos pendientes en este momento.</p>
        </div>
    </div>
@else
    <div class="row g-4">
        @foreach($pendingAssignments as $a)
            @php
                $call = $a->courseCall;
                $course = $call->course;
                $caducado = \Carbon\Carbon::parse($call->end_date)->lt(now());
                $urgente = !$caducado && \Carbon\Carbon::parse($call->end_date)->lte(now()->addDays(7));
            @endphp
            <div class="col-md-6 col-lg-4">
                <div class="card h-100" style="border-left: 4px solid {{ $caducado ? '#dc2626' : ($urgente ? '#f59e0b' : '#2E6DA4') }};">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $course->title }}</h5>
                            @if($caducado)
                                <span class="badge bg-danger ms-2">Caducado</span>
                            @elseif($urgente)
                                <span class="badge bg-warning text-dark ms-2">Urgente</span>
                            @endif
                        </div>

                        <p class="text-muted small mb-3">
                            @if($course->type == 'presencial')
                                <span class="badge bg-success">Presencial</span>
                            @elseif($course->type == 'e-learning')
                                <span class="badge bg-info text-dark">E-learning</span>
                            @else
                                <span class="badge bg-primary">Virtual</span>
                            @endif
                        </p>

                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Inicio: {{ $call->start_date }}
                            </small>
                        </div>
                        <div class="mb-3">
                            <small class="{{ $caducado ? 'text-danger fw-bold' : ($urgente ? 'fw-bold' : 'text-muted') }}">
                                <i class="fas fa-calendar-times me-1"></i>
                                Fin: {{ $call->end_date }}
                            </small>
                        </div>

                        <div>
                            @if($a->status == 'pending')
                                <span class="badge-pending">Pendiente</span>
                            @else
                                <span class="badge-progress">En curso</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
