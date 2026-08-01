<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-chat-square-text"></i>
            {{ $user->name }}
        </h1>
    </x-slot>

    <div class="card border-0" style="box-shadow: var(--shadow-sm);">
        <div class="row g-0" style="min-height: 500px;">
            <!-- Conversation sidebar -->
            <div class="col-md-4 border-end d-none d-md-flex flex-column" style="border-color: var(--border-light) !important;">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 1rem 1.25rem;">
                    <h6 class="mb-0 fw-semibold" style="font-size: 0.875rem;">Messages</h6>
                </div>
                <div class="p-3">
                    <a href="{{ route('messages.index') }}" class="btn btn-secondary btn-sm w-100">
                        <i class="bi bi-arrow-left me-1"></i>Retour aux conversations
                    </a>
                </div>
                <div class="px-3 pb-3">
                    <div class="d-flex align-items-center gap-3 p-2 rounded-lg" style="background: var(--primary-light);">
                        <div class="avatar avatar-sm avatar-primary">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size: 0.875rem;">{{ $user->name }}</div>
                            @if ($user->city)
                                <div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-geo-alt me-1"></i>{{ $user->city }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat area -->
            <div class="col-md-8 d-flex flex-column">
                <!-- Messages list -->
                <div class="flex-grow-1 p-3" style="max-height: 400px; overflow-y: auto; background: var(--background);">
                    @forelse ($messages as $msg)
                        <div class="d-flex {{ $msg->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-3">
                            <div class="chat-bubble {{ $msg->sender_id === auth()->id() ? 'chat-bubble-sent' : 'chat-bubble-received' }}">
                                @if ($msg->sender_id !== auth()->id())
                                    <div class="fw-semibold mb-1" style="font-size: 0.75rem; opacity: 0.8;">{{ $msg->sender->name }}</div>
                                @endif
                                <div>{{ $msg->content }}</div>
                                <div class="chat-bubble-meta mt-1" style="{{ $msg->sender_id === auth()->id() ? 'opacity: 0.7;' : '' }}">
                                    {{ $msg->created_at->format('H:i') }}
                                    @if ($msg->sender_id === auth()->id())
                                        <form action="{{ route('messages.destroy', $msg) }}" method="POST" class="d-inline ms-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border-0 p-0" style="background: none; color: inherit; font-size: inherit; opacity: 0.6; cursor: pointer;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" style="padding: 2rem;">
                            <div class="empty-state-icon">
                                <i class="bi bi-chat-square-text"></i>
                            </div>
                            <div class="empty-state-title">Aucun message</div>
                            <div class="empty-state-text">Commencez la conversation !</div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($messages->hasPages())
                    <div class="px-3 py-2 border-top" style="border-color: var(--border-light) !important;">
                        {{ $messages->links() }}
                    </div>
                @endif

                <!-- Input area -->
                <div class="chat-input-area">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                        <div class="d-flex gap-2 align-items-end">
                            <div class="flex-grow-1">
                                <textarea name="content" rows="1" class="form-control" placeholder="Écrire un message..." required style="resize: none; min-height: 42px; max-height: 120px;">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary" style="height: 42px; padding: 0 1rem;">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
