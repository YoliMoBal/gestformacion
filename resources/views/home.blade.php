<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Plataforma de Formación</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex flex-col justify-center items-center text-center px-6">
    <h1 class="text-4xl font-bold mb-4">
        Panel de Control de Formación
    </h1>

    <p class="text-gray-600 mb-8 max-w-xl">
        Gestiona cursos pendientes, revisa vencimientos y notifica automáticamente a los empleados.
    </p>

    <a href="{{ route('admin.panel') }}"
        class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
        Ir al panel de administración
    </a>
        @endif
    </div>
</div>

</body>
</html>
