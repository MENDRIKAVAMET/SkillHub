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
            <div class="col-md-8 d-flex flex-column" id="chat-panel" data-receiver-id="{{ $user->id }}" data-poll-url="{{ route('messages.poll', $user) }}" data-store-url="{{ route('messages.store') }}" data-auth-id="{{ auth()->id() }}">
                <!-- Messages list -->
                <div class="flex-grow-1 p-3" id="messages-list" style="max-height: 400px; overflow-y: auto; background: var(--background);">
                    @forelse ($messages->sortBy('id') as $msg)
                        <div class="d-flex {{ $msg->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-3" data-message-id="{{ $msg->id }}">
                            <div class="chat-bubble {{ $msg->sender_id === auth()->id() ? 'chat-bubble-sent' : 'chat-bubble-received' }}">
                                @if ($msg->sender_id !== auth()->id())
                                    <div class="fw-semibold mb-1" style="font-size: 0.75rem; opacity: 0.8;">{{ $msg->sender->name }}</div>
                                @endif
                                <div class="chat-bubble-content">{{ $msg->content }}</div>
                                <div class="chat-bubble-meta mt-1" style="{{ $msg->sender_id === auth()->id() ? 'opacity: 0.7;' : '' }}">
                                    <span class="chat-bubble-time">{{ $msg->created_at->format('H:i') }}</span>
                                    @if ($msg->sender_id === auth()->id())
                                        <button type="button" class="btn-delete-message border-0 p-0 ms-2" data-delete-url="{{ route('messages.destroy', $msg) }}" style="background: none; color: inherit; font-size: inherit; opacity: 0.6; cursor: pointer;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" id="empty-messages-state" style="padding: 2rem;">
                            <div class="empty-state-icon">
                                <i class="bi bi-chat-square-text"></i>
                            </div>
                            <div class="empty-state-title">Aucun message</div>
                            <div class="empty-state-text">Commencez la conversation !</div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination (messages plus anciens) -->
                @if ($messages->hasPages())
                    <div class="px-3 py-2 border-top" style="border-color: var(--border-light) !important;">
                        {{ $messages->links() }}
                    </div>
                @endif

                <!-- Input area -->
                <div class="chat-input-area">
                    <form id="message-form">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                        <div class="d-flex gap-2 align-items-end">
                            <div class="flex-grow-1">
                                <textarea name="content" id="message-input" rows="1" class="form-control" placeholder="Écrire un message..." required style="resize: none; min-height: 42px; max-height: 120px;"></textarea>
                                <div class="text-danger small mt-1" id="message-error" style="display: none;"></div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="message-submit" style="height: 42px; padding: 0 1rem;">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    (function () {
        const panel = document.getElementById('chat-panel');
        const list = document.getElementById('messages-list');
        const form = document.getElementById('message-form');
        const input = document.getElementById('message-input');
        const submitBtn = document.getElementById('message-submit');
        const errorBox = document.getElementById('message-error');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const authId = panel.dataset.authId;

        function lastMessageId() {
            const bubbles = list.querySelectorAll('[data-message-id]');
            if (!bubbles.length) return 0;
            return Math.max(...Array.from(bubbles).map(el => parseInt(el.dataset.messageId, 10)));
        }

        function scrollToBottom() {
            list.scrollTop = list.scrollHeight;
        }

        function removeEmptyState() {
            const empty = document.getElementById('empty-messages-state');
            if (empty) empty.remove();
        }

        function attachDeleteHandler(button) {
            button.addEventListener('click', function () {
                if (!confirm('Supprimer ce message ?')) return;
                fetch(button.dataset.deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                }).then(res => res.json()).then(() => {
                    const bubble = button.closest('[data-message-id]');
                    if (bubble) bubble.remove();
                });
            });
        }

        list.querySelectorAll('.btn-delete-message').forEach(attachDeleteHandler);

        function appendMessage(msg) {
            if (list.querySelector('[data-message-id="' + msg.id + '"]')) return;
            removeEmptyState();

            const wrapper = document.createElement('div');
            wrapper.className = 'd-flex ' + (msg.is_mine ? 'justify-content-end' : 'justify-content-start') + ' mb-3';
            wrapper.dataset.messageId = msg.id;

            const senderLine = !msg.is_mine
                ? '<div class="fw-semibold mb-1" style="font-size: 0.75rem; opacity: 0.8;">' + msg.sender_name + '</div>'
                : '';

            const deleteBtn = msg.is_mine
                ? '<button type="button" class="btn-delete-message border-0 p-0 ms-2" data-delete-url="' + msg.delete_url + '" style="background: none; color: inherit; font-size: inherit; opacity: 0.6; cursor: pointer;"><i class="bi bi-trash"></i></button>'
                : '';

            wrapper.innerHTML =
                '<div class="chat-bubble ' + (msg.is_mine ? 'chat-bubble-sent' : 'chat-bubble-received') + '">' +
                    senderLine +
                    '<div class="chat-bubble-content"></div>' +
                    '<div class="chat-bubble-meta mt-1" style="' + (msg.is_mine ? 'opacity: 0.7;' : '') + '">' +
                        '<span class="chat-bubble-time">' + msg.time + '</span>' +
                        deleteBtn +
                    '</div>' +
                '</div>';

            wrapper.querySelector('.chat-bubble-content').textContent = msg.content;
            list.appendChild(wrapper);

            const del = wrapper.querySelector('.btn-delete-message');
            if (del) attachDeleteHandler(del);
        }

        // Envoi du message sans recharger la page
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const content = input.value.trim();
            if (!content) return;

            submitBtn.disabled = true;
            errorBox.style.display = 'none';

            fetch(panel.dataset.storeUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    receiver_id: panel.dataset.receiverId,
                    content: content,
                }),
            }).then(async (res) => {
                if (!res.ok) {
                    const data = await res.json().catch(() => ({}));
                    const firstError = data.errors ? Object.values(data.errors)[0][0] : "Une erreur est survenue.";
                    errorBox.textContent = firstError;
                    errorBox.style.display = 'block';
                    return;
                }
                const data = await res.json();
                appendMessage(data.message);
                scrollToBottom();
                input.value = '';
                input.style.height = 'auto';
            }).finally(() => {
                submitBtn.disabled = false;
            });
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                form.requestSubmit();
            }
        });

        // Polling des nouveaux messages
        function poll() {
            const url = panel.dataset.pollUrl + '?after_id=' + lastMessageId();
            fetch(url, { headers: { 'Accept': 'application/json' } })
                .then(res => res.json())
                .then(data => {
                    if (data.messages && data.messages.length) {
                        data.messages.forEach(appendMessage);
                        scrollToBottom();
                    }
                })
                .catch(() => {});
        }

        scrollToBottom();

        // Met en pause le polling quand l'onglet n'est pas visible (économie de requêtes)
        let pollTimer = setInterval(poll, 3000);
        document.addEventListener('visibilitychange', function () {
            clearInterval(pollTimer);
            if (!document.hidden) {
                poll();
                pollTimer = setInterval(poll, 3000);
            }
        });
    })();
    </script>
    @endpush
</x-app-layout>
