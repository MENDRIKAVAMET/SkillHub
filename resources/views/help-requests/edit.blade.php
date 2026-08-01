<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-pencil"></i>
            Modifier la demande
        </h1>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    <form action="{{ route('help-requests.update', $helpRequest) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="receiver_id" class="form-label">Destinataire</label>
                            <select name="receiver_id" id="receiver_id" class="form-select @error('receiver_id') is-invalid @enderror" required>
                                @foreach ($users as $user)
                                    <option
                                        value="{{ $user->id }}"
                                        data-skills="{{ $user->skills->pluck('name', 'id')->toJson() }}"
                                        {{ old('receiver_id', $helpRequest->receiver_id) == $user->id ? 'selected' : '' }}
                                    >{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('receiver_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="skill_id" class="form-label">Compétence</label>
                            <select name="skill_id" id="skill_id" class="form-select @error('skill_id') is-invalid @enderror" required></select>
                            <div class="text-muted mt-1" id="skill-hint" style="font-size: 0.8125rem;"></div>
                            @error('skill_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" rows="4" class="form-control @error('message') is-invalid @enderror" required>{{ old('message', $helpRequest->message) }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">Statut</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                @foreach (['En attente', 'Acceptée', 'Refusée'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $helpRequest->status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Mettre à jour
                            </button>
                            <a href="{{ route('help-requests.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    (function () {
        const receiverSelect = document.getElementById('receiver_id');
        const skillSelect = document.getElementById('skill_id');
        const skillHint = document.getElementById('skill-hint');
        const currentSkillId = "{{ old('skill_id', $helpRequest->skill_id) }}";

        function refreshSkills() {
            const option = receiverSelect.options[receiverSelect.selectedIndex];
            skillSelect.innerHTML = '';

            let skills = {};
            try {
                skills = option ? JSON.parse(option.dataset.skills || '{}') : {};
            } catch (e) {
                skills = {};
            }

            const entries = Object.entries(skills);

            if (!entries.length) {
                skillSelect.innerHTML = '<option value="">Aucune compétence renseignée par ce membre</option>';
                skillHint.textContent = 'Ce membre n\'a pas encore renseigné de compétences.';
                return;
            }

            skillHint.textContent = 'Compétences proposées par ' + option.text + '.';

            entries.forEach(([id, name]) => {
                const opt = document.createElement('option');
                opt.value = id;
                opt.textContent = name;
                if (currentSkillId === id) {
                    opt.selected = true;
                }
                skillSelect.appendChild(opt);
            });
        }

        receiverSelect.addEventListener('change', refreshSkills);
        refreshSkills();
    })();
    </script>
    @endpush
</x-app-layout>
