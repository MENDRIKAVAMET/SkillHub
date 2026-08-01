<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-search"></i>
            Recherche
        </h1>
    </x-slot>

    <div class="card border-0 mb-4" style="box-shadow: var(--shadow-sm);">
        <div class="card-body-lg">
            <form method="GET" action="{{ route('search') }}">
                <div class="d-flex gap-2">
                    <div class="flex-grow-1">
                        <input type="text" name="q" value="{{ $query }}" class="form-control" placeholder="Rechercher un utilisateur, une compétence, une ville..." autofocus style="font-size: 1rem; padding: 0.75rem 1rem;">
                    </div>
                    <button class="btn btn-primary px-4">
                        <i class="bi bi-search me-1"></i>Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if ($query !== '')
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                    <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 1rem 1.25rem;">
                        <h5 class="mb-0" style="font-size: 0.9375rem; font-weight: 600;">
                            <i class="bi bi-people me-2" style="color: var(--primary);"></i>Utilisateurs
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @forelse ($users as $user)
                            <a href="{{ route('users.show', $user) }}" class="d-flex align-items-center gap-3 px-3 py-3 text-decoration-none border-bottom" style="border-color: var(--border-light) !important; transition: background 150ms;">
                                <div class="avatar avatar-sm avatar-primary">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-semibold text-truncate" style="color: var(--text); font-size: 0.9375rem;">{{ $user->name }}</div>
                                    <div class="text-muted text-truncate" style="font-size: 0.8125rem;">{{ $user->email }}</div>
                                </div>
                                @if ($user->city)
                                    <div class="text-muted d-none d-sm-block" style="font-size: 0.8125rem;">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $user->city }}
                                    </div>
                                @endif
                                <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
                            </a>
                        @empty
                            <div class="empty-state" style="padding: 2rem;">
                                <div class="empty-state-icon">
                                    <i class="bi bi-person-x"></i>
                                </div>
                                <div class="empty-state-title">Aucun utilisateur trouvé</div>
                                <div class="empty-state-text">Essayez avec d'autres termes de recherche.</div>
                            </div>
                        @endforelse
                        <div class="px-3 py-2">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                    <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 1rem 1.25rem;">
                        <h5 class="mb-0" style="font-size: 0.9375rem; font-weight: 600;">
                            <i class="bi bi-lightning-charge me-2" style="color: var(--primary);"></i>Compétences
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @forelse ($skills as $skill)
                            <a href="{{ route('skills.show', $skill) }}" class="d-flex align-items-center gap-3 px-3 py-3 text-decoration-none border-bottom" style="border-color: var(--border-light) !important; transition: background 150ms;">
                                <div style="width: 36px; height: 36px; border-radius: var(--radius-md); background: var(--primary-light); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="bi bi-lightning-charge" style="color: var(--primary); font-size: 0.875rem;"></i>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-semibold text-truncate" style="color: var(--text); font-size: 0.9375rem;">{{ $skill->name }}</div>
                                    @if ($skill->description)
                                        <div class="text-muted text-truncate" style="font-size: 0.8125rem;">{{ $skill->description }}</div>
                                    @endif
                                </div>
                                <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
                            </a>
                        @empty
                            <div class="empty-state" style="padding: 2rem;">
                                <div class="empty-state-icon">
                                    <i class="bi bi-lightning-charge"></i>
                                </div>
                                <div class="empty-state-title">Aucune compétence trouvée</div>
                                <div class="empty-state-text">Essayez avec d'autres termes de recherche.</div>
                            </div>
                        @endforelse
                        <div class="px-3 py-2">
                            {{ $skills->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
