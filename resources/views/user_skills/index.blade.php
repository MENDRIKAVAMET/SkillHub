<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-lightning-charge"></i>
            Mes compétences
        </h1>
        <a href="{{ route('user-skills.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Ajouter
        </a>
    </x-slot>

    <div class="row g-3">
        @forelse ($userSkills as $userSkill)
            <div class="col-md-6 col-lg-4">
                <div class="skill-card h-100">
                    <div class="skill-card-info">
                        <div class="skill-card-name">{{ $userSkill->name }}</div>
                        @if ($userSkill->pivot->level)
                            <div class="mt-1">
                                @php
                                    $levelClass = match($userSkill->pivot->level) {
                                        'Expert' => 'badge-level-expert',
                                        'Avancé' => 'badge-level-avance',
                                        'Intermédiaire' => 'badge-level-intermediaire',
                                        default => 'badge-level-debutant',
                                    };
                                @endphp
                                <span class="badge {{ $levelClass }}">{{ $userSkill->pivot->level }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex gap-1">
                        <a href="{{ route('user-skills.edit', $userSkill->id) }}" class="btn btn-ghost btn-sm" style="padding: 0.375rem 0.5rem;">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('user-skills.destroy', $userSkill->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-ghost btn-sm" style="padding: 0.375rem 0.5rem; color: var(--danger);" onclick="return confirm('Retirer cette compétence ?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-lightning-charge"></i>
                    </div>
                    <div class="empty-state-title">Aucune compétence ajoutée</div>
                    <div class="empty-state-text">Ajoutez vos compétences pour que la communauté puisse vous trouver.</div>
                    <a href="{{ route('user-skills.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Ajouter une compétence
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</x-app-layout>
