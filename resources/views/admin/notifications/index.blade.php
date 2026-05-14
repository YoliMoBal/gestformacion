@extends('layouts.app')

@section('content')

<h1 class="page-title"><i class="fas fa-bell me-2"></i>Notificaciones</h1>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notification)
                    <tr class="{{ $notification->read_at ? '' : 'table-primary' }}">
                        <td>
                            <i class="fas fa-bell me-2 {{ $notification->read_at ? 'text-muted' : 'text-primary' }}"></i>
                            <strong>{{ $notification->data['title'] ?? 'Notificación' }}</strong>
                        </td>
                        <td>{{ $notification->data['message'] ?? '' }}</td>
                        <td>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                {{ $notification->created_at->format('d/m/Y H:i') }}
                            </small>
                        </td>
                        <td>
                            @if($notification->read_at)
                                <span class="badge-completed">Leída</span>
                            @else
                                <span class="badge-pending">No leída</span>
                            @endif
                        </td>
                        <td>
                            @if(!$notification->read_at)
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                    @csrf
                                    <button class="btn btn-sm btn-primary">
                                        <i class="fas fa-check me-1"></i>Marcar leída
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-bell-slash me-2"></i>No hay notificaciones
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $notifications->links() }}
</div>

@endsection


