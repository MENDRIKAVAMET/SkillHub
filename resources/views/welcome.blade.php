<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'SkillHub') }} — Partage de compétences</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://cdn.jsdelivr.net">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-skillhub">
            <div class="container px-4">
                <a class="navbar-brand" href="#">
                    <div class="brand-icon">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    SkillHub
                </a>
                <div class="d-flex align-items-center gap-2">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-arrow-right"></i>
                                Tableau de bord
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">
                                Connexion
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                                    S'inscrire
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero -->
        <section class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #818cf8 100%); padding: 5rem 0 6rem;">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>
            <div class="container px-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="mb-3" style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.15); padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.8125rem; color: rgba(255,255,255,0.9);">
                            <i class="bi bi-stars"></i>
                            Plateforme collaborative d'entraide
                        </div>
                        <h1 class="text-white fw-bold mb-3" style="font-size: 3rem; line-height: 1.1; letter-spacing: -0.03em;">
                            Partagez vos compétences.<br>
                            Apprenez de votre communauté.
                        </h1>
                        <p class="text-white mb-4" style="font-size: 1.125rem; opacity: 0.85; max-width: 540px; line-height: 1.7;">
                            SkillHub connecte ceux qui savent avec ceux qui veulent apprendre. Ajoutez vos compétences, trouvez des mentors, et échangez ensemble.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            @unless (Auth::check())
                                <a href="{{ route('register') }}" class="btn btn-lg text-primary fw-semibold" style="background: white; border: none; padding: 0.75rem 1.75rem; border-radius: var(--radius-lg);">
                                    Commencer gratuitement
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-lg text-white fw-medium" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); padding: 0.75rem 1.75rem; border-radius: var(--radius-lg);">
                                    J'ai déjà un compte
                                </a>
                            @else
                                <a href="{{ url('/dashboard') }}" class="btn btn-lg text-primary fw-semibold" style="background: white; border: none; padding: 0.75rem 1.75rem; border-radius: var(--radius-lg);">
                                    Mon tableau de bord
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            @endunless
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="py-5" style="margin-top: -2rem; position: relative; z-index: 1;">
            <div class="container px-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0" style="box-shadow: var(--shadow-md);">
                            <div class="card-body p-4">
                                <div style="width: 48px; height: 48px; border-radius: var(--radius-lg); background: var(--primary-light); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                                    <i class="bi bi-lightning-charge" style="color: var(--primary); font-size: 1.25rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Partagez vos skills</h5>
                                <p class="text-muted mb-0" style="font-size: 0.9375rem; line-height: 1.6;">
                                    Présentez les compétences que vous maîtrisez et votre niveau d'expertise à la communauté.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0" style="box-shadow: var(--shadow-md);">
                            <div class="card-body p-4">
                                <div style="width: 48px; height: 48px; border-radius: var(--radius-lg); background: var(--success-light); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                                    <i class="bi bi-book" style="color: var(--success); font-size: 1.25rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Exprimez vos besoins</h5>
                                <p class="text-muted mb-0" style="font-size: 0.9375rem; line-height: 1.6;">
                                    Créez des demandes d'apprentissage et trouvez des mentors prêts à vous guider.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0" style="box-shadow: var(--shadow-md);">
                            <div class="card-body p-4">
                                <div style="width: 48px; height: 48px; border-radius: var(--radius-lg); background: var(--warning-light); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                                    <i class="bi bi-heart" style="color: var(--warning); font-size: 1.25rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Entraidez-vous</h5>
                                <p class="text-muted mb-0" style="font-size: 0.9375rem; line-height: 1.6;">
                                    Envoyez des demandes d'aide et communiquez en messagerie privée avec la communauté.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats -->
        <section class="py-4" style="background: var(--surface); border-top: 1px solid var(--border-light); border-bottom: 1px solid var(--border-light);">
            <div class="container px-4">
                <div class="row g-4 text-center">
                    <div class="col-md-3 col-6">
                        <div class="stat-card-icon icon-primary mx-auto mb-2" style="width: 40px; height: 40px;">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <div class="stat-card-value">{{ \App\Models\Skill::count() }}</div>
                        <div class="stat-card-label">Compétences</div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card-icon icon-info mx-auto mb-2" style="width: 40px; height: 40px;">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="stat-card-value">{{ \App\Models\User::count() }}</div>
                        <div class="stat-card-label">Membres</div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card-icon icon-success mx-auto mb-2" style="width: 40px; height: 40px;">
                            <i class="bi bi-book"></i>
                        </div>
                        <div class="stat-card-value">{{ \App\Models\LearningRequest::count() }}</div>
                        <div class="stat-card-label">Besoins</div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card-icon icon-warning mx-auto mb-2" style="width: 40px; height: 40px;">
                            <i class="bi bi-heart"></i>
                        </div>
                        <div class="stat-card-value">{{ \App\Models\HelpRequest::count() }}</div>
                        <div class="stat-card-label">Demandes d'aide</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-4" style="background: var(--surface);">
            <div class="container px-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="brand-icon" style="width: 24px; height: 24px; font-size: 0.7rem;">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <span class="fw-semibold" style="font-size: 0.875rem; color: var(--text-secondary);">SkillHub</span>
                    </div>
                    <div class="text-muted" style="font-size: 0.8125rem;">
                        Plateforme collaborative de partage de compétences
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
