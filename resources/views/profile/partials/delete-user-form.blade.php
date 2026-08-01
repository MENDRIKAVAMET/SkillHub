<section>
    <header class="mb-4">
        <h4 class="fw-bold mb-1" style="font-size: 1.125rem; color: var(--danger);">
            <i class="bi bi-trash me-2"></i>Supprimer le compte
        </h4>
        <p class="text-muted mb-0" style="font-size: 0.875rem;">
            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées.
        </p>
    </header>

    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
        <i class="bi bi-trash me-1"></i>Supprimer le compte
    </button>

    <!-- Modal de confirmation -->
    <div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: var(--radius-xl); border: none; box-shadow: var(--shadow-lg);">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header" style="border-bottom: 1px solid var(--border-light); padding: 1.25rem;">
                        <h5 class="modal-title fw-bold" id="confirmUserDeletionLabel" style="font-size: 1rem;">
                            <i class="bi bi-exclamation-triangle me-2" style="color: var(--danger);"></i>Êtes-vous sûr ?
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <p class="text-muted mb-3" style="font-size: 0.875rem; line-height: 1.6;">
                            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Veuillez entrer votre mot de passe pour confirmer.
                        </p>
                        <div>
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Votre mot de passe actuel">
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid var(--border-light); padding: 1rem 1.25rem;">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash me-1"></i>Supprimer le compte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
