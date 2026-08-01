<section>
    <header class="mb-4">
        <h4 class="fw-bold mb-1" style="font-size: 1.125rem;">
            <i class="bi bi-person-badge me-2" style="color: var(--primary);"></i>Informations du profil
        </h4>
        <p class="text-muted mb-0" style="font-size: 0.875rem;">
            Mettez à jour votre photo, biographie, ville et adresse email.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="d-flex align-items-center gap-4 mb-4">
            @if ($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil" class="rounded-circle" style="width: 72px; height: 72px; object-fit: cover; border: 3px solid var(--border-light);">
            @else
                <div class="avatar avatar-lg avatar-primary">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <label for="photo" class="form-label mb-1">Photo de profil</label>
                <input type="file" name="photo" id="photo" class="form-control form-control-sm @error('photo') is-invalid @enderror" accept="image/*">
                @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-2 rounded-lg" style="background: var(--warning-light); font-size: 0.8125rem;">
                    <i class="bi bi-exclamation-triangle me-1" style="color: var(--warning);"></i>
                    Votre adresse email n'est pas vérifiée.
                    <button form="send-verification" class="border-0 p-0 fw-semibold" style="background: none; color: var(--primary); cursor: pointer;">
                        Renvoyer l'email de vérification.
                    </button>
                </div>
                @if (session('status') === 'verification-link-sent')
                    <div class="mt-2 p-2 rounded-lg" style="background: var(--success-light); font-size: 0.8125rem; color: #065f46;">
                        <i class="bi bi-check-circle me-1"></i>
                        Un nouveau lien de vérification a été envoyé.
                    </div>
                @endif
            @endif
        </div>

        <div class="mb-3">
            <label for="bio" class="form-label">Bio <span class="text-muted fw-normal">(optionnel)</span></label>
            <textarea name="bio" id="bio" rows="3" class="form-control @error('bio') is-invalid @enderror" placeholder="Parlez de vous en quelques mots...">{{ old('bio', $user->bio) }}</textarea>
            @error('bio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="city" class="form-label">Ville <span class="text-muted fw-normal">(optionnel)</span></label>
            <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $user->city) }}" placeholder="Ex : Paris, Lyon..." autocomplete="address-level2">
            @error('city')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i>Enregistrer
            </button>
            @if (session('status') === 'profile-updated')
                <span class="text-success" style="font-size: 0.875rem;">
                    <i class="bi bi-check-circle me-1"></i>Sauvegardé.
                </span>
            @endif
        </div>
    </form>
</section>
