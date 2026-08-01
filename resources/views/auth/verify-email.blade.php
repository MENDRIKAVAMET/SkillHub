<x-guest-layout>
    <h4 class="fw-bold text-center mb-4"><i class="bi bi-envelope-check me-2"></i>Vérification de l'email</h4>

    <div class="mb-4 text-muted small text-center">
        Merci de votre inscription ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ?
        Si vous n'avez pas reçu l'email, nous vous en enverrons un autre avec plaisir.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 alert alert-success small">
            Un nouveau lien de vérification a été envoyé à l'adresse email que vous avez fournie lors de l'inscription.
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-envelope me-1"></i>Renvoyer l'email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="btn btn-outline-secondary">
                <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
            </button>
        </form>
    </div>
</x-guest-layout>
