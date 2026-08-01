<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="page-title">
                <i class="bi bi-house"></i>
                Bonjour, {{ Str::before(Auth::user()->name, ' ') }} 👋
            </h1>
            <p class="text-muted mt-1 mb-0" style="font-size: 0.9375rem;">Voici un résumé de votre activité sur SkillHub</p>
        </div>
    </x-slot>

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg">
            <div class="stat-card h-100 hover-lift">
                <div class="stat-card-icon icon-primary">
                    <i class="bi bi-lightning-charge"></i>
                </div>
                <div>
                    <div class="stat-card-value">{{ $skillCount }}</div>
                    <div class="stat-card-label">Compétences</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg">
            <div class="stat-card h-100 hover-lift">
                <div class="stat-card-icon icon-success">
                    <i class="bi bi-book"></i>
                </div>
                <div>
                    <div class="stat-card-value">{{ $learningRequestCount }}</div>
                    <div class="stat-card-label">Besoins</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg">
            <div class="stat-card h-100 hover-lift">
                <div class="stat-card-icon icon-warning">
                    <i class="bi bi-arrow-up-right"></i>
                </div>
                <div>
                    <div class="stat-card-value">{{ $helpRequestsSent }}</div>
                    <div class="stat-card-label">Aides envoyées</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg">
            <div class="stat-card h-100 hover-lift">
                <div class="stat-card-icon icon-info">
                    <i class="bi bi-arrow-down-left"></i>
                </div>
                <div>
                    <div class="stat-card-value">{{ $helpRequestsReceived }}</div>
                    <div class="stat-card-label">Aides reçues</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg">
            <div class="stat-card h-100 hover-lift">
                <div class="stat-card-icon icon-danger">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <div>
                    <div class="stat-card-value">{{ $messageCount }}</div>
                    <div class="stat-card-label">Messages</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 1rem 1.25rem;">
                    <h5 class="mb-0" style="font-size: 0.9375rem; font-weight: 600;">
                        <i class="bi bi-activity me-2" style="color: var(--primary);"></i>Dernières activités
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse ($recentActivities as $activity)
                        <div class="activity-item px-3">
                            <div class="activity-icon" style="background: var(--primary-light); color: var(--primary);">
                                <i class="bi bi-lightning-charge"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">{{ $activity['title'] }}</div>
                                <div class="activity-text">{{ $activity['text'] }}</div>
                            </div>
                            <div class="activity-time">{{ $activity['time'] }}</div>
                        </div>
                    @empty
                        <div class="empty-state" style="padding: 2rem;">
                            <div class="empty-state-icon">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <div class="empty-state-title">Aucune activité récente</div>
                            <div class="empty-state-text">Commencez par ajouter des compétences ou créer un besoin.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 mb-4" style="box-shadow: var(--shadow-sm);">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 1rem 1.25rem;">
                    <h5 class="mb-0" style="font-size: 0.9375rem; font-weight: 600;">
                        <i class="bi bi-lightning me-2" style="color: var(--primary);"></i>Actions rapides
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('user-skills.create') }}" class="btn btn-secondary btn-sm justify-content-start">
                            <i class="bi bi-plus-circle text-primary"></i>
                            Ajouter une compétence
                        </a>
                        <a href="{{ route('learning-requests.create') }}" class="btn btn-secondary btn-sm justify-content-start">
                            <i class="bi bi-book text-success"></i>
                            Créer un besoin d'apprentissage
                        </a>
                        <a href="{{ route('help-requests.create') }}" class="btn btn-secondary btn-sm justify-content-start">
                            <i class="bi bi-heart text-warning"></i>
                            Demander de l'aide
                        </a>
                        <a href="{{ route('search') }}" class="btn btn-secondary btn-sm justify-content-start">
                            <i class="bi bi-search text-info"></i>
                            Rechercher des membres
                        </a>
                    </div>
                </div>
            </div>

            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 1rem 1.25rem;">
                    <h5 class="mb-0" style="font-size: 0.9375rem; font-weight: 600;">
                        <i class="bi bi-person me-2" style="color: var(--primary);"></i>Votre profil
                    </h5>
                </div>
                <div class="card-body text-center p-4">
                    <div class="avatar avatar-lg avatar-primary mx-auto mb-3">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h6 class="fw-bold mb-1">{{ Auth::user()->name }}</h6>
                    @if (Auth::user()->city)
                        <div class="text-muted" style="font-size: 0.8125rem;"><i class="bi bi-geo-alt me-1"></i>{{ Auth::user()->city }}</div>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="btn btn-secondary btn-sm mt-3">
                        <i class="bi bi-pencil me-1"></i>Modifier le profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
