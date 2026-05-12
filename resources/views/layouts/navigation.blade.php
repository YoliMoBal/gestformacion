<nav class="navbar-main">
    <div class="d-flex align-items-center justify-content-between" style="max-width: 1400px; margin: 0 auto;">

        <!-- LOGO -->
        <a href="{{ route('landing') }}" class="navbar-brand-text text-decoration-none">
            <i class="fas fa-graduation-cap me-2"></i>Gest<span>Formación</span>
        </a>

        <!-- LINKS -->
        <div class="d-flex align-items-center gap-1">
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
                    <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-user me-1"></i>Mis cursos
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
                            <li><hr class="dropdown-divider"></li>
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
</nav>