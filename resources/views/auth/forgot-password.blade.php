<x-guest-layout>
    <h4 class="fw-bold text-center mb-4"><i class="bi bi-key me-2"></i>Mot de passe oublié</h4>

    <div class="mb-4 text-muted small text-center">
        Mot de passe oublié ? Pas de problème. Indiquez-nous votre adresse email et nous vous enverrons un lien de réinitialisation.
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 alert alert-success small">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a class="text-decoration-none small" href="{{ route('login') }}">
                <i class="bi bi-arrow-left me-1"></i>Retour à la connexion
            </a>

            <button class="btn btn-primary">
                <i class="bi bi-envelope me-1"></i>Envoyer le lien
            </button>
        </div>
    </form>
</x-guest-layout>
