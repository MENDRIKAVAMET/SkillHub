<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-book"></i>
            Besoin d'apprentissage
        </h1>
    </x-slot>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="avatar avatar-md avatar-primary">
                            {{ strtoupper(substr($learningRequest->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <a href="{{ route('users.show', $learningRequest->user) }}" class="fw-semibold text-decoration-none" style="color: var(--text); font-size: 1rem;">{{ $learningRequest->user->name }}</a>
                            <div class="text-muted" style="font-size: 0.8125rem;">{{ $learningRequest->created_at->format('d/m/Y à H:i') }}</div>
                        </div>
                        <span class="badge badge-status-attente ms-auto">{{ $learningRequest->status }}</span>
                    </div>

                    <div class="mb-3">
                        <span class="badge badge-level-avance" style="font-size: 0.8125rem; padding: 0.375rem 0.75rem;">
                            <i class="bi bi-lightning-charge me-1"></i>{{ $learningRequest->skill->name }}
                        </span>
                    </div>

                    @if ($learningRequest->message)
                        <div style="padding: 1rem; background: var(--background); border-radius: var(--radius-lg); font-size: 0.9375rem; line-height: 1.7; color: var(--text-secondary);">
                            {{ $learningRequest->message }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('learning-requests.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Retour
                </a>
                @can('update', $learningRequest)
                    <a href="{{ route('learning-requests.edit', $learningRequest) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil me-1"></i>Modifier
                    </a>
                @endcan
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 1rem 1.25rem;">
                    <h5 class="mb-0" style="font-size: 0.9375rem; font-weight: 600;">
                        <i class="bi bi-people me-2" style="color: var(--primary);"></i>Mentors disponibles
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse ($matchedMentors as $mentor)
                        <a href="{{ route('users.show', $mentor) }}" class="d-flex align-items-center gap-3 px-3 py-3 text-decoration-none border-bottom" style="border-color: var(--border-light) !important; transition: background 150ms;">
                            <div class="avatar avatar-sm avatar-primary">
                                {{ strtoupper(substr($mentor->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <div class="fw-semibold text-truncate" style="color: var(--text); font-size: 0.875rem;">{{ $mentor->name }}</div>
                                @if ($mentor->city)
                                    <div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-geo-alt me-1"></i>{{ $mentor->city }}</div>
                                @endif
                            </div>
                            <span class="badge badge-level-avance" style="font-size: 0.6875rem;">{{ $mentor->skills->first()->pivot->level ?? '' }}</span>
                        </a>
                    @empty
                        <div class="empty-state" style="padding: 2rem;">
                            <div class="empty-state-icon" style="width: 48px; height: 48px;">
                                <i class="bi bi-person-x"></i>
                            </div>
                            <div class="empty-state-title">Aucun mentor trouvé</div>
                            <div class="empty-state-text" style="font-size: 0.8125rem;">Aucun membre ne maîtrise cette compétence pour le moment.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
