<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-pencil"></i>
            Modifier le niveau
        </h1>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    <form action="{{ route('user-skills.update', $userSkill->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="skill_id" class="form-label">Compétence</label>
                            <select name="skill_id" id="skill_id" class="form-select @error('skill_id') is-invalid @enderror" required>
                                @foreach ($skills as $skill)
                                    <option value="{{ $skill->id }}" {{ old('skill_id', $userSkill->skill_id) == $skill->id ? 'selected' : '' }}>{{ $skill->name }}</option>
                                @endforeach
                            </select>
                            @error('skill_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="level" class="form-label">Niveau</label>
                            <select name="level" id="level" class="form-select @error('level') is-invalid @enderror" required>
                                @foreach (['Débutant', 'Intermédiaire', 'Avancé', 'Expert'] as $level)
                                    <option value="{{ $level }}" {{ old('level', $currentLevel) == $level ? 'selected' : '' }}>{{ $level }}</option>
                                @endforeach
                            </select>
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Mettre à jour
                            </button>
                            <a href="{{ route('user-skills.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
