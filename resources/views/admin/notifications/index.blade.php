
@extends('layouts.app')


@section('content')
<div class="max-w-7xl mx-auto py-6">

    <h1 class="text-2xl font-bold mb-6">Notificaciones</h1>

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr class="border-b">
                <th class="px-4 py-2 text-left">Título</th>
                <th class="px-4 py-2 text-left">Mensaje</th>
                <th class="px-4 py-2 text-left">Fecha</th>
                <th class="px-4 py-2 text-left">Estado</th>
                <th class="px-4 py-2 text-left">Acción</th>
            </tr>
        </thead>

        <tbody>
        @forelse ($notifications as $notification)
            <tr class="border-b {{ $notification->read_at ? '' : 'bg-blue-50' }}">
                <td class="px-4 py-2 font-semibold">
                    {{ $notification->data['title'] ?? 'Notificación' }}
                </td>

                <td class="px-4 py-2">
                    {{ $notification->data['message'] ?? '' }}
                </td>

                <td class="px-4 py-2">
                    {{ $notification->created_at->format('d/m/Y H:i') }}
                </td>

                <td class="px-4 py-2">
                    {{ $notification->read_at ? 'Leída' : 'No leída' }}
                </td>

                <td class="px-4 py-2">
                    @if(!$notification->read_at)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            <button class="text-blue-600 hover:underline">
                                Marcar como leída
                            </button>
                        </form>
                    @else
                        —
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                    No hay notificaciones
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>

</div>
@endsection





