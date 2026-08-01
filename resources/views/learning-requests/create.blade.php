<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-plus-circle"></i>
            Nouveau besoin d'apprentissage
        </h1>
    </x-slot>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    <form action="{{ route('learning-requests.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="skill_id" class="form-label">Compétence souhaitée</label>
                            <select name="skill_id" id="skill_id" class="form-select @error('skill_id') is-invalid @enderror" required>
                                <option value="">Sélectionner une compétence</option>
                                @foreach ($skills as $skill)
                                    <option value="{{ $skill->id }}" {{ old('skill_id') == $skill->id ? 'selected' : '' }}>{{ $skill->name }}</option>
                                @endforeach
                            </select>
                            @error('skill_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" rows="4" class="form-control @error('message') is-invalid @enderror" placeholder="Expliquez ce que vous souhaitez apprendre..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Créer le besoin
                            </button>
                            <a href="{{ route('learning-requests.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 1rem 1.25rem;">
                    <h5 class="mb-0" style="font-size: 0.9375rem; font-weight: 600;">
                        <i class="bi bi-people me-2" style="color: var(--primary);"></i>Mentors disponibles
                    </h5>
                </div>
                <div class="card-body p-0" id="mentors-container">
                    <div class="empty-state" style="padding: 2rem;">
                        <div class="empty-state-icon" style="width: 48px; height: 48px;">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="empty-state-title">Sélectionnez une compétence</div>
                        <div class="empty-state-text" style="font-size: 0.8125rem;">Les mentors correspondants s'afficheront ici.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const skillSelect = document.getElementById('skill_id');
            const container = document.getElementById('mentors-container');

            if (skillSelect) {
                skillSelect.addEventListener('change', function() {
                    const skillId = this.value;
                    if (!skillId) {
                        container.innerHTML = '<div class="empty-state" style="padding: 2rem;"><div class="empty-state-icon" style="width: 48px; height: 48px;"><i class="bi bi-people"></i></div><div class="empty-state-title">Sélectionnez une compétence</div><div class="empty-state-text" style="font-size: 0.8125rem;">Les mentors correspondants s\'afficheront ici.</div></div>';
                        return;
                    }

                    container.innerHTML = '<div class="text-center py-4"><div class="spinner-border" style="color: var(--primary);" role="status"><span class="visually-hidden">Chargement...</span></div></div>';

                    fetch(`/learning-requests/match/${skillId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.mentors && data.mentors.length > 0) {
                                let html = '';
                                data.mentors.forEach(mentor => {
                                    html += `
                                        <a href="/users/${mentor.id}" class="d-flex align-items-center gap-3 px-3 py-3 text-decoration-none border-bottom" style="border-color: var(--border-light) !important; transition: background 150ms;">
                                            <div class="avatar avatar-sm avatar-primary">${mentor.name.charAt(0).toUpperCase()}</div>
                                            <div class="flex-grow-1 min-width-0">
                                                <div class="fw-semibold text-truncate" style="color: var(--text); font-size: 0.875rem;">${mentor.name}</div>
                                                ${mentor.city ? `<div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-geo-alt me-1"></i>${mentor.city}</div>` : ''}
                                            </div>
                                            <span class="badge badge-level-avance" style="font-size: 0.6875rem;">${mentor.level}</span>
                                        </a>
                                    `;
                                });
                                container.innerHTML = html;
                            } else {
                                container.innerHTML = '<div class="empty-state" style="padding: 2rem;"><div class="empty-state-icon" style="width: 48px; height: 48px;"><i class="bi bi-person-x"></i></div><div class="empty-state-title">Aucun mentor trouvé</div><div class="empty-state-text" style="font-size: 0.8125rem;">Aucun membre ne maîtrise cette compétence.</div></div>';
                            }
                        })
                        .catch(() => {
                            container.innerHTML = '<div class="empty-state" style="padding: 2rem;"><div class="empty-state-icon" style="width: 48px; height: 48px;"><i class="bi bi-exclamation-circle"></i></div><div class="empty-state-title">Erreur</div><div class="empty-state-text" style="font-size: 0.8125rem;">Impossible de charger les mentors.</div></div>';
                        });
                });
            }
        });
    </script>
</x-app-layout>
