<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 alert alert-success small">
            {{ session('status') }}
        </div>
    @endif

    <h4 class="fw-bold text-center mb-4"><i class="bi bi-box-arrow-in-right me-2"></i>Connexion</h4>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label small text-muted" for="remember_me">Se souvenir de moi</label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a class="text-decoration-none small" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif

            <button class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
            </button>
        </div>
    </form>

    <hr class="my-4">

    <div class="text-center">
        <span class="small text-muted">Pas encore de compte ?</span>
        <a href="{{ route('register') }}" class="text-decoration-none small">S'inscrire</a>
    </div>
</x-guest-layout>
