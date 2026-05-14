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

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0" style="font-size: 1.1rem; font-weight: 700;">{{ $course->title }}</h5>
                            @if($caducado)
                                <span class="badge bg-danger ms-2">Caducado</span>
                            @elseif($urgente)
                                <span class="badge bg-warning text-dark ms-2">Urgente</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            @if($course->type == 'presencial')
                                <span class="badge bg-success" style="font-size: 0.85rem;">Presencial</span>
                            @elseif($course->type == 'e-learning')
                                <span class="badge bg-info text-dark" style="font-size: 0.85rem;">E-learning</span>
                            @else
                                <span class="badge bg-primary" style="font-size: 0.85rem;">Virtual</span>
                            @endif
                        </div>

                        <div class="mb-2" style="font-size: 1rem;">
                            <i class="fas fa-calendar-alt me-2 text-muted"></i>
                            <strong>Inicio:</strong> {{ $call->start_date }}
                        </div>

                        <div class="mb-3" style="font-size: 1rem;">
                            <i class="fas fa-calendar-times me-2 {{ $caducado ? 'text-danger' : 'text-muted' }}"></i>
                            <strong class="{{ $caducado ? 'text-danger' : ($urgente ? 'text-warning' : '') }}">
                                Fin: {{ $call->end_date }}
                            </strong>
                        </div>

                        <div>
                            @if($a->status == 'pending')
                                <span class="badge-pending" style="font-size: 0.95rem; padding: 6px 14px;">Pendiente</span>
                            @else
                                <span class="badge-progress" style="font-size: 0.95rem; padding: 6px 14px;">En curso</span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
