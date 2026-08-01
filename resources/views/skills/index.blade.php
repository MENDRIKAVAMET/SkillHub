<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-lightning-charge"></i>
            Compétences
        </h1>
        <a href="{{ route('skills.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Ajouter
        </a>
    </x-slot>

    <div class="row g-3">
        @forelse ($skills as $skill)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('skills.show', $skill) }}" class="text-decoration-none">
                    <div class="skill-card h-100">
                        <div class="skill-card-info">
                            <div class="skill-card-name">{{ $skill->name }}</div>
                            @if ($skill->description)
                                <div class="skill-card-desc">{{ $skill->description }}</div>
                            @endif
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('skills.edit', $skill) }}" class="btn btn-ghost btn-sm" style="padding: 0.375rem 0.5rem;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('skills.destroy', $skill) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-sm" style="padding: 0.375rem 0.5rem; color: var(--danger);" onclick="return confirm('Supprimer cette compétence ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-lightning-charge"></i>
                    </div>
                    <div class="empty-state-title">Aucune compétence</div>
                    <div class="empty-state-text">Soyez le premier à ajouter une compétence à la plateforme.</div>
                    <a href="{{ route('skills.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Ajouter une compétence
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</x-app-layout>
