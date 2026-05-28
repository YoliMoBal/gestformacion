<nav class="navbar-main">
    <div class="d-flex align-items-center justify-content-between" style="max-width: 1400px; margin: 0 auto; width: 100%;">

        <!-- LOGO -->
        <a href="{{ route('landing') }}" class="navbar-brand-text text-decoration-none d-flex align-items-center">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo"
                style="width: 35px; height: 35px; border-radius: 8px; object-fit: contain; margin-right: 8px; background: white;">
            Gest<span>Formación</span>
        </a>

        <!-- BOTÓN HAMBURGUESA (solo móvil) -->
        <button class="d-lg-none btn" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
            style="color: white; border: 1px solid rgba(255,255,255,0.4); border-radius: 8px; padding: 6px 10px;">
            <i class="fas fa-bars"></i>
        </button>

        <!-- LINKS (escritorio) -->
        <div class="d-none d-lg-flex align-items-center gap-1">
            @auth
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.panel') }}" class="nav-link-custom {{ request()->routeIs('admin.panel') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-1"></i>Panel
            </a>
            <a href="{{ route('users.index') }}" class="nav-link-custom {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fas fa-users me-1"></i>Usuarios
            </a>
            <a href="{{ route('courses.index') }}" class="nav-link-custom {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                <i class="fas fa-book me-1"></i>Cursos
            </a>
            <a href="{{ route('course-calls.index') }}" class="nav-link-custom {{ request()->routeIs('course-calls.*') ? 'active' : '' }}">
                <i class="fas fa-calendar me-1"></i>Convocatorias
            </a>
            <a href="{{ route('assignments.index') }}" class="nav-link-custom {{ request()->routeIs('assignments.*') ? 'active' : '' }}">
                <i class="fas fa-tasks me-1"></i>Asignaciones
            </a>
            <a href="{{ route('notifications.index') }}" class="nav-link-custom {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                <i class="fas fa-bell me-1"></i>Notificaciones
                @if(auth()->user()->unreadNotifications->count())
                <span class="nav-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </a>
            @else
            <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                @php
                $cursosUrgentes = \App\Models\CourseAssignment::where('user_id', auth()->id())
                ->where('status', '!=', 'completed')
                ->whereHas('courseCall', fn($q) => $q->whereDate('end_date', '<=', now()->addDays(7)))
                    ->count();
                    @endphp
                    <i class="fas fa-book-open me-1"></i>Mis cursos
                    @if($cursosUrgentes > 0)
                    <span class="nav-badge">{{ $cursosUrgentes }}</span>
                    @endif
            </a>
            <a href="{{ route('dashboard.history') }}" class="nav-link-custom {{ request()->routeIs('dashboard.history') ? 'active' : '' }}">
                <i class="fas fa-history me-1"></i>Histórico
            </a>
            @endif

            <!-- USER DROPDOWN -->
            <div class="user-dropdown ms-3">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-cog me-2"></i>Perfil
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            @endauth
        </div>
    </div>

    <!-- MENÚ MÓVIL (hamburguesa desplegable) -->
    <div class="collapse d-lg-none" id="navMenu">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0.5rem 0; border-top: 1px solid rgba(255,255,255,0.2);">
            @auth
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.panel') }}" class="nav-link-custom d-block py-2">
                <i class="fas fa-chart-line me-2"></i>Panel
            </a>
            <a href="{{ route('users.index') }}" class="nav-link-custom d-block py-2">
                <i class="fas fa-users me-2"></i>Usuarios
            </a>
            <a href="{{ route('courses.index') }}" class="nav-link-custom d-block py-2">
                <i class="fas fa-book me-2"></i>Cursos
            </a>
            <a href="{{ route('course-calls.index') }}" class="nav-link-custom d-block py-2">
                <i class="fas fa-calendar me-2"></i>Convocatorias
            </a>
            <a href="{{ route('assignments.index') }}" class="nav-link-custom d-block py-2">
                <i class="fas fa-tasks me-2"></i>Asignaciones
            </a>
            <a href="{{ route('notifications.index') }}" class="nav-link-custom d-block py-2">
                <i class="fas fa-bell me-2"></i>Notificaciones
            </a>
            @else
            <a href="{{ route('dashboard') }}" class="nav-link-custom d-block py-2">
                <i class="fas fa-book-open me-2"></i>Mis cursos
            </a>
            <a href="{{ route('dashboard.history') }}" class="nav-link-custom d-block py-2">
                <i class="fas fa-history me-2"></i>Histórico
            </a>
            @endif
            <hr style="border-color: rgba(255,255,255,0.2);">
            <a href="{{ route('profile.edit') }}" class="nav-link-custom d-block py-2">
                <i class="fas fa-cog me-2"></i>Perfil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link-custom d-block py-2 w-100 text-start" style="background:none; border:none;">
                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión
                </button>
            </form>
            @endauth
        </div>
    </div>
</nav>