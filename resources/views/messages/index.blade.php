<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-chat-dots"></i>
            Messagerie
        </h1>
    </x-slot>

    <div class="card border-0" style="box-shadow: var(--shadow-sm);">
        <div class="row g-0" style="min-height: 500px;">
            <!-- Conversations sidebar -->
            <div class="col-md-4 border-end" style="border-color: var(--border-light) !important;">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 1rem 1.25rem;">
                    <h6 class="mb-0 fw-semibold" style="font-size: 0.875rem;">Conversations</h6>
                </div>
                <div style="max-height: 480px; overflow-y: auto;">
                    @forelse ($users as $contact)
                        <a href="{{ route('messages.show', ['user' => $contact->id]) }}" class="d-flex align-items-center gap-3 px-3 py-3 text-decoration-none border-bottom" style="border-color: var(--border-light) !important; transition: background 150ms;">
                            <div class="avatar avatar-sm avatar-primary">
                                {{ strtoupper(substr($contact->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <div class="fw-semibold text-truncate" style="color: var(--text); font-size: 0.9375rem;">{{ $contact->name }}</div>
                            </div>
                            <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
                        </a>
                    @empty
                        <div class="empty-state" style="padding: 2rem;">
                            <div class="empty-state-icon" style="width: 48px; height: 48px;">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            <div class="empty-state-title">Aucun contact</div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Main area -->
            <div class="col-md-8 d-flex align-items-center justify-content-center" style="background: var(--background);">
                <div class="text-center">
                    <div class="empty-state-icon mx-auto">
                        <i class="bi bi-chat-square-text"></i>
                    </div>
                    <div class="empty-state-title">Sélectionnez une conversation</div>
                    <div class="empty-state-text">Choisissez un contact dans la liste pour commencer à discuter.</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
