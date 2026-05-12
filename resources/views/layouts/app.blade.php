<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GestFormación</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Inter', sans-serif; }

        body { background-color: #f0f4f8; }

        /* NAVBAR */
        .navbar-main {
            background: linear-gradient(135deg, #1a3a5c 0%, #2E6DA4 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            padding: 0.75rem 1.5rem;
        }
        .navbar-brand-text {
            font-size: 1.3rem;
            font-weight: 700;
            color: white !important;
            letter-spacing: 0.5px;
        }
        .navbar-brand-text span { color: #7dd3fc; }

        .nav-link-custom {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.5rem 1rem !important;
            border-radius: 6px;
            transition: all 0.2s;
            text-decoration: none;
        }
        .nav-link-custom:hover, .nav-link-custom.active {
            color: white !important;
            background: rgba(255,255,255,0.15);
        }
        .nav-badge {
            background: #ef4444;
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 4px;
        }
        .user-dropdown .btn {
            color: white;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 8px;
            font-size: 0.9rem;
            padding: 0.4rem 1rem;
        }
        .user-dropdown .btn:hover {
            background: rgba(255,255,255,0.25);
            color: white;
        }

        /* CARDS */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .card-header-custom {
            background: linear-gradient(135deg, #1a3a5c, #2E6DA4);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }

        /* BUTTONS */
        .btn-primary {
            background: linear-gradient(135deg, #1a3a5c, #2E6DA4);
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2E6DA4, #1a3a5c);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(46,109,164,0.4);
        }
        .btn-success { border-radius: 8px; font-weight: 500; }
        .btn-warning { border-radius: 8px; font-weight: 500; }
        .btn-danger  { border-radius: 8px; font-weight: 500; }
        .btn-secondary { border-radius: 8px; font-weight: 500; }

        /* TABLES */
        .table { border-radius: 8px; overflow: hidden; }
        .table thead th {
            background: #1a3a5c;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            padding: 1rem;
        }
        .table tbody tr {
            transition: background 0.15s;
        }
        .table tbody tr:hover { background: #f0f7ff; }
        .table tbody td {
            padding: 0.85rem 1rem;
            vertical-align: middle;
            border-color: #e5e7eb;
            font-size: 0.9rem;
        }

        /* BADGES */
        .badge-activo {
            background: #dcfce7; color: #16a34a;
            padding: 4px 10px; border-radius: 20px;
            font-size: 0.8rem; font-weight: 600;
        }
        .badge-inactivo {
            background: #fee2e2; color: #dc2626;
            padding: 4px 10px; border-radius: 20px;
            font-size: 0.8rem; font-weight: 600;
        }
        .badge-pending {
            background: #fef9c3; color: #ca8a04;
            padding: 4px 10px; border-radius: 20px;
            font-size: 0.8rem; font-weight: 600;
        }
        .badge-progress {
            background: #dbeafe; color: #2563eb;
            padding: 4px 10px; border-radius: 20px;
            font-size: 0.8rem; font-weight: 600;
        }
        .badge-completed {
            background: #dcfce7; color: #16a34a;
            padding: 4px 10px; border-radius: 20px;
            font-size: 0.8rem; font-weight: 600;
        }

        /* PAGE TITLE */
        .page-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a3a5c;
            margin-bottom: 1.5rem;
        }

        /* ALERTS */
        .alert { border-radius: 10px; border: none; }
        .alert-success { background: #dcfce7; color: #16a34a; }

        /* FORMS */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 0.9rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2E6DA4;
            box-shadow: 0 0 0 3px rgba(46,109,164,0.15);
        }
        .form-label { font-weight: 500; font-size: 0.9rem; color: #374151; }
    </style>
</head>
<body>
    @include('layouts.navigation')

    <main class="container-fluid px-4 py-4" style="max-width: 1400px; margin: 0 auto;">
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>