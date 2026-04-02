<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Formación</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex flex-col justify-center items-center text-center">
    <h1 class="text-4xl font-bold mb-8">
        Gestión de Formación
    </h1>

    <p class="text-gray-600 mb-10">
        Selecciona tu tipo de acceso
    </p>

    <div class="space-x-6">
        <a href="{{ route('dashboard') }}"
           class="bg-blue-600 text-white px-8 py-4 rounded text-lg hover:bg-blue-700">
            👨‍🏫 Empleado
        </a>

        <a href="{{ route('admin.panel') }}"
           class="bg-gray-800 text-white px-8 py-4 rounded text-lg hover:bg-gray-900">
            👩‍💼 Administrador
        </a>
    </div>
</div>

</body>
</html>
