<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GestFormación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background-image: linear-gradient(rgba(26, 58, 92, 0.75), rgba(26, 58, 92, 0.75)),
                url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: bgZoom 20s ease-in-out infinite alternate;
        }

        @keyframes bgZoom {
            0% {
                background-size: 100%;
            }

            100% {
                background-size: 120%;
            }
        }

        .landing-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            max-width: 500px;
            width: 90%;
            text-align: center;
            backdrop-filter: blur(10px);
            animation: fadeInUp 0.8s ease-out;
            box-shadow: 0 0 0 3px rgba(125, 211, 252, 0.8),
                0 25px 60px rgba(0, 0, 0, 0.4);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .app-title {
            font-size: 2rem;
            font-weight: 800;
            color: #1a3a5c;
            margin-bottom: 0.5rem;
        }

        .app-title span {
            color: #2E6DA4;
        }

        .app-subtitle {
            color: #6b7280;
            font-size: 1rem;
            margin-bottom: 2.5rem;
        }

        .btn-empleado {
            background: linear-gradient(135deg, #2E6DA4, #1a3a5c);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.9rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            margin-bottom: 1rem;
            transition: all 0.2s;
            text-decoration: none;
            display: block;
        }

        .btn-empleado:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46, 109, 164, 0.4);
            color: white;
        }

        .btn-admin {
            background: white;
            color: #1a3a5c;
            border: 2px solid #1a3a5c;
            border-radius: 12px;
            padding: 0.9rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.2s;
            text-decoration: none;
            display: block;
        }

        .btn-admin:hover {
            background: #1a3a5c;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26, 58, 92, 0.3);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-top: 1px solid #e5e7eb;
        }

        .divider span {
            padding: 0 1rem;
            color: #9ca3af;
            font-size: 0.85rem;
        }

        .footer-text {
            margin-top: 2rem;
            font-size: 0.8rem;
            color: #9ca3af;
        }
    </style>
</head>

<body>
    <div class="landing-card">
        <div class="logo-icon">
            <img src="{{ asset('images/logo.jpg') }}" alt="GestFormación"
                style="width: 90%; height: 90%; object-fit: contain; margin: 5%;">
        </div>


        <h1 class="app-title">Gest<span>Formación</span></h1>
        <p class="app-subtitle">Panel de gestión de formación empresarial</p>

        <a href="{{ route('login') }}" class="btn-empleado">
            <i class="fas fa-user-tie me-2"></i>Acceso Empleado
        </a>

        <div class="divider"><span>o</span></div>

        <a href="{{ route('login') }}" class="btn-admin">
            <i class="fas fa-shield-alt me-2"></i>Acceso Administrador
        </a>

        <p class="footer-text">
            <i class="fas fa-lock me-1"></i>Acceso restringido a personal autorizado
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>