<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-lightning-charge"></i>
            {{ $skill->name }}
        </h1>
    </x-slot>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h3 class="fw-bold mb-1">{{ $skill->name }}</h3>
                            <span class="badge badge-level-intermediaire">Compétence</span>
                        </div>
                    </div>

                    @if ($skill->description)
                        <p class="text-secondary" style="line-height: 1.7;">{{ $skill->description }}</p>
                    @else
                        <p class="text-muted fst-italic">Aucune description renseignée.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    <h6 class="fw-semibold mb-3" style="font-size: 0.875rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em;">Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('skills.edit', $skill) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil me-1"></i>Modifier
                        </a>
                        <form action="{{ route('skills.destroy', $skill) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Supprimer cette compétence ?')">
                                <i class="bi bi-trash me-1"></i>Supprimer
                            </button>
                        </form>
                        <a href="{{ route('skills.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i>Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
