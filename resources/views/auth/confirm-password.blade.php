<x-guest-layout>
    <h4 class="fw-bold text-center mb-4"><i class="bi bi-shield-check me-2"></i>Confirmation requise</h4>

    <div class="mb-4 text-muted small text-center">
        Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe pour continuer.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary">
                <i class="bi bi-check-circle me-1"></i>Confirmer
            </button>
        </div>
    </form>
</x-guest-layout>
