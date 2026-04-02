<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Código concesión</th>
            <th>Ubicación</th>
            <th>Departamento</th>
            <th>Puesto</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->perfilEmpleado?->codigoConcesionario?->codigo }}</td>
                <td>{{ $user->perfilEmpleado?->codigoConcesionario?->ubicacion?->nombre }}</td>
                <td>{{ $user->perfilEmpleado?->departamento?->nombre }}</td>
                <td>{{ $user->perfilEmpleado?->puesto?->nombre }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
