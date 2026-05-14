<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GestFormación — Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background-image: linear-gradient(rgba(26,58,92,0.75), rgba(26,58,92,0.75)),
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
            0%   { background-size: 100%; }
            100% { background-size: 120%; }
        }
        .login-card {
            background: rgba(255,255,255,0.97);
            border-radius: 20px;
            padding: 2.5rem;
            max-width: 420px;
            width: 90%;
            box-shadow: 0 0 0 3px rgba(125,211,252,0.8), 0 25px 60px rgba(0,0,0,0.4);
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #1a3a5c, #2E6DA4);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
        }
        .app-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1a3a5c;
            text-align: center;
            margin-bottom: 0.2rem;
        }
        .app-title span { color: #2E6DA4; }
        .app-subtitle {
            color: #6b7280;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #d1d5db;
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #2E6DA4;
            box-shadow: 0 0 0 3px rgba(46,109,164,0.15);
        }
        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #374151;
        }
        .btn-login {
            background: linear-gradient(135deg, #2E6DA4, #1a3a5c);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46,109,164,0.4);
            color: white;
        }
        .password-wrapper {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 0;
            font-size: 1rem;
        }
        .password-toggle:hover { color: #2E6DA4; }
        .back-link {
            text-align: center;
            margin-top: 1.2rem;
        }
        .back-link a {
            color: #6b7280;
            font-size: 0.85rem;
            text-decoration: none;
        }
        .back-link a:hover { color: #1a3a5c; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo-icon">
            <i class="fas fa-graduation-cap text-white"></i>
        </div>
        <h1 class="app-title">Gest<span>Formación</span></h1>
        <p class="app-subtitle">Inicia sesión para continuar</p>

        @if(session('status'))
            <div class="alert alert-success mb-3">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="fas fa-exclamation-circle me-2"></i>
                Las credenciales no coinciden con nuestros registros.
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input id="email" type="email" name="email"
                    class="form-control" value="{{ old('email') }}"
                    placeholder="tu@email.com" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <div class="password-wrapper">
                    <input id="password" type="password" name="password"
                        class="form-control pe-5" placeholder="••••••••" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small text-muted" for="remember">Recordarme</label>
                </div>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="small text-muted">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Iniciar sesión
            </button>
        </form>

        <div class="back-link">
            <a href="{{ route('landing') }}">
                <i class="fas fa-arrow-left me-1"></i>Volver al inicio
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(fieldId, btn) {
            const field = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>