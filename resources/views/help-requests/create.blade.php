<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-plus-circle"></i>
            Nouvelle demande d'aide
        </h1>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    <form action="{{ route('help-requests.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="receiver_id" class="form-label">Destinataire</label>
                            <select name="receiver_id" id="receiver_id" class="form-select @error('receiver_id') is-invalid @enderror" required>
                                <option value="">Sélectionner un membre</option>
                                @foreach ($users as $user)
                                    <option
                                        value="{{ $user->id }}"
                                        data-skills="{{ $user->skills->pluck('name', 'id')->toJson() }}"
                                        {{ old('receiver_id') == $user->id ? 'selected' : '' }}
                                    >{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('receiver_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="skill_id" class="form-label">Compétence</label>
                            <select name="skill_id" id="skill_id" class="form-select @error('skill_id') is-invalid @enderror" required disabled>
                                <option value="">Choisissez d'abord un destinataire</option>
                            </select>
                            <div class="text-muted mt-1" id="skill-hint" style="font-size: 0.8125rem;">
                                Sélectionnez un membre pour voir les compétences qu'il propose.
                            </div>
                            @error('skill_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" rows="4" class="form-control @error('message') is-invalid @enderror" placeholder="Expliquez votre demande d'aide..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submit-btn">
                                <i class="bi bi-send me-1"></i>Envoyer la demande
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
        const submitBtn = document.getElementById('submit-btn');
        const oldSkillId = "{{ old('skill_id') }}";

        function refreshSkills() {
            const option = receiverSelect.options[receiverSelect.selectedIndex];
            skillSelect.innerHTML = '';

            if (!option || !option.value) {
                skillSelect.disabled = true;
                skillSelect.innerHTML = '<option value="">Choisissez d\'abord un destinataire</option>';
                skillHint.textContent = 'Sélectionnez un membre pour voir les compétences qu\'il propose.';
                submitBtn.disabled = false;
                return;
            }

            let skills = {};
            try {
                skills = JSON.parse(option.dataset.skills || '{}');
            } catch (e) {
                skills = {};
            }

            const entries = Object.entries(skills);

            if (!entries.length) {
                skillSelect.disabled = true;
                skillSelect.innerHTML = '<option value="">Aucune compétence renseignée par ce membre</option>';
                skillHint.textContent = 'Ce membre n\'a pas encore renseigné de compétences. Choisissez un autre destinataire, ou invitez-le à en ajouter.';
                skillHint.classList.add('text-warning-custom');
                submitBtn.disabled = true;
                return;
            }

            skillSelect.disabled = false;
            submitBtn.disabled = false;
            skillHint.classList.remove('text-warning-custom');
            skillHint.textContent = 'Compétences proposées par ' + option.text + '.';

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Sélectionner une compétence';
            skillSelect.appendChild(placeholder);

            entries.forEach(([id, name]) => {
                const opt = document.createElement('option');
                opt.value = id;
                opt.textContent = name;
                if (oldSkillId && oldSkillId === id) {
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
