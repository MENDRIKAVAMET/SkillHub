<nav class="navbar navbar-expand-lg navbar-skillhub">
    <div class="container px-4">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <div class="brand-icon">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>
            SkillHub
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Navigation">
            <i class="bi bi-list fs-4 text-secondary"></i>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                <li class="nav-item">
                    <a class="nav-link nav-link-skillhub {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-house"></i>
                        <span>Accueil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-skillhub {{ request()->routeIs('skills.*') ? 'active' : '' }}" href="{{ route('skills.index') }}">
                        <i class="bi bi-lightning-charge"></i>
                        <span>Compétences</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-skillhub {{ request()->routeIs('learning-requests.*') ? 'active' : '' }}" href="{{ route('learning-requests.index') }}">
                        <i class="bi bi-book"></i>
                        <span>Apprendre</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-skillhub {{ request()->routeIs('help-requests.*') ? 'active' : '' }}" href="{{ route('help-requests.index') }}">
                        <i class="bi bi-heart"></i>
                        <span>Entraide</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-skillhub {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="{{ route('messages.index') }}">
                        <i class="bi bi-chat-dots"></i>
                        <span>Messages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-skillhub {{ request()->routeIs('search') ? 'active' : '' }}" href="{{ route('search') }}">
                        <i class="bi bi-search"></i>
                        <span>Rechercher</span>
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('skills.create') }}" class="btn btn-primary btn-sm d-none d-lg-inline-flex">
                    <i class="bi bi-plus-lg"></i>
                    <span>Nouvelle compétence</span>
                </a>

                <div class="dropdown">
                    <button class="btn btn-ghost dropdown-toggle d-flex align-items-center gap-2 px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar avatar-sm avatar-primary">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="d-none d-lg-inline text-secondary fw-medium" style="font-size: 0.875rem;">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="min-width: 200px; border-radius: var(--radius-lg); padding: 0.5rem;">
                        <li class="px-2 py-1">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-sm avatar-primary">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size: 0.875rem;">{{ Auth::user()->name }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('user-skills.index') }}" style="border-radius: var(--radius-md); padding: 0.5rem 0.75rem; font-size: 0.875rem;">
                                <i class="bi bi-lightning-charge text-muted"></i>
                                Mes compétences
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.edit') }}" style="border-radius: var(--radius-md); padding: 0.5rem 0.75rem; font-size: 0.875rem;">
                                <i class="bi bi-person text-muted"></i>
                                Mon profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2 w-100 text-danger" style="border-radius: var(--radius-md); padding: 0.5rem 0.75rem; font-size: 0.875rem;">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
