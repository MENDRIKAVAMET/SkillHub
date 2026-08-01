<section>
    <header class="mb-4">
        <h4 class="fw-bold mb-1" style="font-size: 1.125rem;">
            <i class="bi bi-shield-lock me-2" style="color: var(--primary);"></i>Mettre à jour le mot de passe
        </h4>
        <p class="text-muted mb-0" style="font-size: 0.875rem;">
            Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Mot de passe actuel</label>
            <input type="password" name="current_password" id="update_password_current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">Nouveau mot de passe</label>
            <input type="password" name="password" id="update_password_password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="update_password_password_confirmation" class="form-control" autocomplete="new-password">
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i>Mettre à jour
            </button>
            @if (session('status') === 'password-updated')
                <span class="text-success" style="font-size: 0.875rem;">
                    <i class="bi bi-check-circle me-1"></i>Sauvegardé.
                </span>
            @endif
        </div>
    </form>
</section>
