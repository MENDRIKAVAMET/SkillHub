<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-person"></i>
            {{ $user->name }}
        </h1>
    </x-slot>

    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body text-center p-4">
                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil" class="rounded-circle mb-3" style="width: 96px; height: 96px; object-fit: cover; border: 3px solid var(--border-light);">
                    @else
                        <div class="avatar avatar-xl avatar-primary mx-auto mb-3">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>

                    @if ($user->city)
                        <div class="text-muted mb-2" style="font-size: 0.875rem;"><i class="bi bi-geo-alt me-1"></i>{{ $user->city }}</div>
                    @endif

                    @if ($user->bio)
                        <p class="text-muted mb-0" style="font-size: 0.875rem; line-height: 1.6;">{{ $user->bio }}</p>
                    @endif

                    <hr style="border-color: var(--border-light); margin: 1rem 0;">

                    <div class="row text-center">
                        <div class="col-4">
                            <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">{{ $user->skills->count() }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Compétences</div>
                        </div>
                        <div class="col-4">
                            <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">{{ $learningRequestsCount }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Besoins</div>
                        </div>
                        <div class="col-4">
                            <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">{{ $helpRequestsSentCount + $helpRequestsReceivedCount }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Aides</div>
                        </div>
                    </div>

                    <hr style="border-color: var(--border-light); margin: 1rem 0;">

                    <div class="d-grid gap-2">
                        <a href="{{ route('messages.show', ['user' => $user->id]) }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-chat-dots me-1"></i>Envoyer un message
                        </a>
                        <a href="{{ route('help-requests.create') }}?receiver_id={{ $user->id }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-heart me-1"></i>Demander de l'aide
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Skills Section -->
        <div class="col-lg-8">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 1rem 1.25rem;">
                    <h5 class="mb-0" style="font-size: 0.9375rem; font-weight: 600;">
                        <i class="bi bi-lightning-charge me-2" style="color: var(--primary);"></i>Compétences de {{ $user->name }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse ($user->skills as $skill)
                        <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom" style="border-color: var(--border-light) !important;">
                            <div class="flex-grow-1 min-width-0">
                                <div class="fw-semibold" style="color: var(--text); font-size: 0.9375rem;">{{ $skill->name }}</div>
                                @if ($skill->description)
                                    <div class="text-muted" style="font-size: 0.8125rem;">{{ $skill->description }}</div>
                                @endif
                            </div>
                            @php
                                $levelClass = match($skill->pivot->level) {
                                    'Expert' => 'badge-level-expert',
                                    'Avancé' => 'badge-level-avance',
                                    'Intermédiaire' => 'badge-level-intermediaire',
                                    default => 'badge-level-debutant',
                                };
                            @endphp
                            <span class="badge {{ $levelClass }}">{{ $skill->pivot->level }}</span>
                        </div>
                    @empty
                        <div class="empty-state" style="padding: 2rem;">
                            <div class="empty-state-icon">
                                <i class="bi bi-lightning-charge"></i>
                            </div>
                            <div class="empty-state-title">Aucune compétence renseignée</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
