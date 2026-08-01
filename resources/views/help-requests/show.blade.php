<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-heart"></i>
            Demande d'aide
        </h1>
    </x-slot>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <span class="badge badge-level-avance" style="font-size: 0.8125rem; padding: 0.375rem 0.75rem;">
                            <i class="bi bi-lightning-charge me-1"></i>{{ $helpRequest->skill->name }}
                        </span>
                        @php
                            $statusClass = match($helpRequest->status) {
                                'Acceptée' => 'badge-status-acceptee',
                                'Refusée' => 'badge-status-refusee',
                                default => 'badge-status-attente',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}" style="font-size: 0.8125rem; padding: 0.375rem 0.75rem;">{{ $helpRequest->status }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-4 mb-4">
                        <div class="text-center">
                            <div class="avatar avatar-md avatar-primary mx-auto mb-2">
                                {{ strtoupper(substr($helpRequest->sender->name, 0, 1)) }}
                            </div>
                            <div class="text-muted" style="font-size: 0.6875rem; text-transform: uppercase; letter-spacing: 0.05em;">Expéditeur</div>
                            <a href="{{ route('users.show', $helpRequest->sender) }}" class="fw-semibold text-decoration-none" style="color: var(--text); font-size: 0.875rem;">{{ $helpRequest->sender->name }}</a>
                        </div>
                        <div style="color: var(--muted-light);"><i class="bi bi-arrow-right"></i></div>
                        <div class="text-center">
                            <div class="avatar avatar-md" style="background: var(--success); color: white; margin: 0 auto 0.5rem;">{{ strtoupper(substr($helpRequest->receiver->name, 0, 1)) }}</div>
                            <div class="text-muted" style="font-size: 0.6875rem; text-transform: uppercase; letter-spacing: 0.05em;">Destinataire</div>
                            <a href="{{ route('users.show', $helpRequest->receiver) }}" class="fw-semibold text-decoration-none" style="color: var(--text); font-size: 0.875rem;">{{ $helpRequest->receiver->name }}</a>
                        </div>
                    </div>

                    @if ($helpRequest->message)
                        <div style="padding: 1rem; background: var(--background); border-radius: var(--radius-lg); font-size: 0.9375rem; line-height: 1.7; color: var(--text-secondary);">
                            {{ $helpRequest->message }}
                        </div>
                    @endif

                    <div class="text-muted mt-3" style="font-size: 0.8125rem;">
                        <i class="bi bi-clock me-1"></i>{{ $helpRequest->created_at->format('d/m/Y à H:i') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    <h6 class="fw-semibold mb-3" style="font-size: 0.875rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em;">Actions</h6>
                    <div class="d-grid gap-2">
                        @if($helpRequest->receiver_id === auth()->id() && $helpRequest->status === 'En attente')
                            <form action="{{ route('help-requests.accept', $helpRequest) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm w-100" style="background: var(--success); color: white; border: none;">
                                    <i class="bi bi-check-circle me-1"></i>Accepter
                                </button>
                            </form>
                            <form action="{{ route('help-requests.refuse', $helpRequest) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="bi bi-x-circle me-1"></i>Refuser
                                </button>
                            </form>
                        @endif

                        @can('update', $helpRequest)
                            <a href="{{ route('help-requests.edit', $helpRequest) }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-pencil me-1"></i>Modifier
                            </a>
                        @endcan

                        <a href="{{ route('help-requests.index') }}" class="btn btn-ghost btn-sm" style="color: var(--muted);">
                            <i class="bi bi-arrow-left me-1"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
