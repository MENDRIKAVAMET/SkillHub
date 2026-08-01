<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-heart"></i>
            Demandes d'aide
        </h1>
        <a href="{{ route('help-requests.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Nouvelle demande
        </a>
    </x-slot>

    <div class="row g-3">
        @forelse ($helpRequests as $helpRequest)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 h-100" style="box-shadow: var(--shadow-sm); transition: all 200ms;">
                    <a href="{{ route('help-requests.show', $helpRequest) }}" class="text-decoration-none">
                        <div class="card-body-lg pb-2">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="badge badge-level-avance">{{ $helpRequest->skill->name }}</span>
                                @php
                                    $statusClass = match($helpRequest->status) {
                                        'Acceptée' => 'badge-status-acceptee',
                                        'Refusée' => 'badge-status-refusee',
                                        default => 'badge-status-attente',
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $helpRequest->status }}</span>
                            </div>

                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="avatar avatar-sm avatar-primary">
                                    {{ strtoupper(substr($helpRequest->sender->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="text-muted" style="font-size: 0.75rem;">De</div>
                                    <span class="fw-semibold text-truncate d-block" style="color: var(--text); font-size: 0.875rem;">{{ $helpRequest->sender->name }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="avatar avatar-sm" style="background: var(--success); color: white;">
                                    {{ strtoupper(substr($helpRequest->receiver->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="text-muted" style="font-size: 0.75rem;">À</div>
                                    <span class="fw-semibold text-truncate d-block" style="color: var(--text); font-size: 0.875rem;">{{ $helpRequest->receiver->name }}</span>
                                </div>
                            </div>

                            <div class="text-muted" style="font-size: 0.75rem;">
                                <i class="bi bi-clock me-1"></i>{{ $helpRequest->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </a>

                    @if ($helpRequest->receiver_id === auth()->id() && $helpRequest->status === 'En attente')
                        <div class="card-body-lg pt-0">
                            <div class="d-flex gap-2">
                                <form action="{{ route('help-requests.accept', $helpRequest) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <button type="submit" class="btn btn-sm w-100" style="background: var(--success); color: white; border: none;">
                                        <i class="bi bi-check-circle me-1"></i>Accepter
                                    </button>
                                </form>
                                <form action="{{ route('help-requests.refuse', $helpRequest) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="bi bi-x-circle me-1"></i>Refuser
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-heart"></i>
                    </div>
                    <div class="empty-state-title">Aucune demande d'aide</div>
                    <div class="empty-state-text">Envoyez une demande pour obtenir de l'aide d'un membre de la communauté.</div>
                    <a href="{{ route('help-requests.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Créer une demande
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if ($helpRequests->hasPages())
        <div class="mt-4">
            {{ $helpRequests->links() }}
        </div>
    @endif
</x-app-layout>
