<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-book"></i>
            Besoins d'apprentissage
        </h1>
        <a href="{{ route('learning-requests.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Ajouter
        </a>
    </x-slot>

    <div class="row g-3">
        @forelse ($requests as $request)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('learning-requests.show', $request) }}" class="text-decoration-none">
                    <div class="card border-0 h-100" style="box-shadow: var(--shadow-sm); transition: all 200ms;">
                        <div class="card-body-lg">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="avatar avatar-sm avatar-primary">
                                    {{ strtoupper(substr($request->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-semibold text-truncate" style="color: var(--text); font-size: 0.9375rem;">{{ $request->user->name }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $request->created_at->diffForHumans() }}</div>
                                </div>
                                <span class="badge badge-status-attente">{{ $request->status }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="badge badge-level-avance">{{ $request->skill->name }}</span>
                            </div>
                            @if ($request->message)
                                <p class="text-muted mb-0" style="font-size: 0.8125rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $request->message }}
                                </p>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 px-4 pb-3">
                            <div class="d-flex gap-2">
                                <a href="{{ route('learning-requests.edit', $request) }}" class="btn btn-ghost btn-sm" style="color: var(--muted);">
                                    <i class="bi bi-pencil me-1"></i>Modifier
                                </a>
                                <form action="{{ route('learning-requests.destroy', $request) }}" method="POST" class="ms-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color: var(--danger);" onclick="return confirm('Supprimer ce besoin ?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="empty-state-title">Aucun besoin d'apprentissage</div>
                    <div class="empty-state-text">Créez un besoin pour trouver des mentors qualifiés.</div>
                    <a href="{{ route('learning-requests.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Créer un besoin
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if ($requests->hasPages())
        <div class="mt-4">
            {{ $requests->links() }}
        </div>
    @endif
</x-app-layout>
