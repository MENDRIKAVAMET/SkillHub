<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-plus-circle"></i>
            Ajouter une compétence
        </h1>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    <form action="{{ route('user-skills.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="skill_id" class="form-label">Compétence</label>
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
                            <label for="level" class="form-label">Niveau</label>
                            <select name="level" id="level" class="form-select @error('level') is-invalid @enderror" required>
                                <option value="">Sélectionner un niveau</option>
                                @foreach (['Débutant', 'Intermédiaire', 'Avancé', 'Expert'] as $level)
                                    <option value="{{ $level }}" {{ old('level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                                @endforeach
                            </select>
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Enregistrer
                            </button>
                            <a href="{{ route('user-skills.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
