<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'SkillHub') }} — Partage de compétences</title>
        <script>
            (function () {
                var stored = localStorage.getItem('theme');
                var theme = stored || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                document.documentElement.setAttribute('data-bs-theme', theme);
            })();
        </script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
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
                    <button type="button" class="theme-toggle" data-theme-toggle aria-label="Basculer le thème sombre">
                        <span class="theme-toggle-knob"><i class="bi bi-sun-fill" data-theme-icon></i></span>
                    </button>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">
                                Tableau de bord
                                <i class="bi bi-arrow-right"></i>
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
        <section class="position-relative overflow-hidden" style="background: var(--gradient-brand); padding: 6rem 0 8rem;">
            <div class="blob" style="width: 420px; height: 420px; background: #ffffff; top: -140px; left: -100px;"></div>
            <div class="blob" style="width: 360px; height: 360px; background: #fbcfe8; bottom: -160px; right: -60px; animation-delay: -5s;"></div>
            <div class="blob" style="width: 240px; height: 240px; background: #c4b5fd; top: 40%; right: 12%; animation-delay: -9s; opacity: 0.35;"></div>
            <div class="position-absolute top-0 start-0 w-100 h-100 grid-pattern"></div>

            <div class="container px-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-8 mx-auto text-center">
                        <div class="mb-4" data-reveal style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.8125rem; color: rgba(255,255,255,0.95); backdrop-filter: blur(6px);">
                            <i class="bi bi-stars"></i>
                            Plateforme collaborative d'entraide
                        </div>
                        <h1 class="text-white fw-bold mb-4" data-reveal style="font-family: var(--font-display); font-size: clamp(2.25rem, 5vw, 3.5rem); line-height: 1.1; letter-spacing: -0.03em;">
                            Partagez vos compétences.<br>
                            Apprenez de votre communauté.
                        </h1>
                        <p class="text-white mb-5 mx-auto" data-reveal style="font-size: 1.1875rem; opacity: 0.88; max-width: 560px; line-height: 1.7;">
                            SkillHub connecte ceux qui savent avec ceux qui veulent apprendre. Ajoutez vos compétences, trouvez des mentors, et échangez ensemble.
                        </p>
                        <div class="d-flex flex-wrap justify-content-center gap-3" data-reveal>
                            @unless (Auth::check())
                                <a href="{{ route('register') }}" class="btn btn-lg fw-semibold" style="background: white; color: var(--primary-hover); border: none; padding: 0.8125rem 1.875rem; border-radius: var(--radius-lg); box-shadow: 0 12px 28px -8px rgba(0,0,0,0.35);">
                                    Commencer gratuitement
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-lg text-white fw-medium" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.3); padding: 0.8125rem 1.875rem; border-radius: var(--radius-lg); backdrop-filter: blur(6px);">
                                    J'ai déjà un compte
                                </a>
                            @else
                                <a href="{{ url('/dashboard') }}" class="btn btn-lg fw-semibold" style="background: white; color: var(--primary-hover); border: none; padding: 0.8125rem 1.875rem; border-radius: var(--radius-lg); box-shadow: 0 12px 28px -8px rgba(0,0,0,0.35);">
                                    Mon tableau de bord
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            @endunless
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats strip (floating over hero) -->
        <section class="px-4" style="margin-top: -4.5rem; position: relative; z-index: 2;">
            <div class="container px-0">
                <div class="card card-glass border-0 mx-auto" style="max-width: 920px; box-shadow: var(--shadow-xl); border-radius: var(--radius-xl);">
                    <div class="row g-0 text-center">
                        <div class="col-6 col-md-3 p-4 border-end border-light-custom">
                            <div class="stat-card-value text-gradient" style="font-size: 1.875rem;">{{ \App\Models\Skill::count() }}</div>
                            <div class="stat-card-label">Compétences</div>
                        </div>
                        <div class="col-6 col-md-3 p-4 border-end border-light-custom">
                            <div class="stat-card-value text-gradient" style="font-size: 1.875rem;">{{ \App\Models\User::count() }}</div>
                            <div class="stat-card-label">Membres</div>
                        </div>
                        <div class="col-6 col-md-3 p-4 border-end border-light-custom" style="border-top: 1px solid var(--border-light);">
                            <div class="stat-card-value text-gradient" style="font-size: 1.875rem;">{{ \App\Models\LearningRequest::count() }}</div>
                            <div class="stat-card-label">Besoins d'apprentissage</div>
                        </div>
                        <div class="col-6 col-md-3 p-4" style="border-top: 1px solid var(--border-light);">
                            <div class="stat-card-value text-gradient" style="font-size: 1.875rem;">{{ \App\Models\HelpRequest::count() }}</div>
                            <div class="stat-card-label">Demandes d'aide</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="py-5 mt-4">
            <div class="container px-4">
                <div class="text-center mb-5" style="max-width: 620px; margin-inline: auto;" data-reveal>
                    <div class="eyebrow justify-content-center mb-2">Pourquoi SkillHub</div>
                    <h2 class="fw-bold mb-3">Tout ce qu'il faut pour apprendre et transmettre</h2>
                    <p class="text-muted mb-0">Une plateforme pensée pour rendre le partage de compétences simple, humain et efficace.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4" data-reveal>
                        <div class="card h-100 border-0 hover-lift" style="box-shadow: var(--shadow-sm);">
                            <div class="card-body p-4">
                                <div style="width: 52px; height: 52px; border-radius: var(--radius-lg); background: var(--primary-light); display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem;">
                                    <i class="bi bi-lightning-charge" style="color: var(--primary); font-size: 1.375rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Partagez vos skills</h5>
                                <p class="text-muted mb-0" style="font-size: 0.9375rem; line-height: 1.65;">
                                    Présentez les compétences que vous maîtrisez et votre niveau d'expertise à la communauté.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" data-reveal>
                        <div class="card h-100 border-0 hover-lift" style="box-shadow: var(--shadow-sm);">
                            <div class="card-body p-4">
                                <div style="width: 52px; height: 52px; border-radius: var(--radius-lg); background: var(--success-light); display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem;">
                                    <i class="bi bi-book" style="color: var(--success); font-size: 1.375rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Exprimez vos besoins</h5>
                                <p class="text-muted mb-0" style="font-size: 0.9375rem; line-height: 1.65;">
                                    Créez des demandes d'apprentissage et trouvez des mentors prêts à vous guider.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" data-reveal>
                        <div class="card h-100 border-0 hover-lift" style="box-shadow: var(--shadow-sm);">
                            <div class="card-body p-4">
                                <div style="width: 52px; height: 52px; border-radius: var(--radius-lg); background: var(--warning-light); display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem;">
                                    <i class="bi bi-heart" style="color: var(--warning); font-size: 1.375rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Entraidez-vous</h5>
                                <p class="text-muted mb-0" style="font-size: 0.9375rem; line-height: 1.65;">
                                    Envoyez des demandes d'aide et communiquez en messagerie privée avec la communauté.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section class="py-5" style="background: var(--surface); border-top: 1px solid var(--border-light); border-bottom: 1px solid var(--border-light);">
            <div class="container px-4 py-4">
                <div class="text-center mb-5" data-reveal>
                    <div class="eyebrow justify-content-center mb-2">Comment ça marche</div>
                    <h2 class="fw-bold mb-0">Trois étapes pour commencer</h2>
                </div>
                <div class="row g-4">
                    <div class="col-md-4" data-reveal>
                        <div class="d-flex align-items-start gap-3">
                            <div class="step-number">1</div>
                            <div>
                                <h6 class="fw-bold mb-1">Créez votre profil</h6>
                                <p class="text-muted mb-0" style="font-size: 0.875rem; line-height: 1.6;">Inscrivez-vous et listez les compétences que vous maîtrisez déjà.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" data-reveal>
                        <div class="d-flex align-items-start gap-3">
                            <div class="step-number">2</div>
                            <div>
                                <h6 class="fw-bold mb-1">Exprimez vos besoins</h6>
                                <p class="text-muted mb-0" style="font-size: 0.875rem; line-height: 1.6;">Publiez une demande d'apprentissage ou parcourez celles des autres membres.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" data-reveal>
                        <div class="d-flex align-items-start gap-3">
                            <div class="step-number">3</div>
                            <div>
                                <h6 class="fw-bold mb-1">Échangez et progressez</h6>
                                <p class="text-muted mb-0" style="font-size: 0.875rem; line-height: 1.6;">Contactez un membre en message privé et organisez votre entraide.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA -->
        @unless (Auth::check())
        <section class="py-5">
            <div class="container px-4 py-4">
                <div class="position-relative overflow-hidden rounded-xl text-center px-4 py-5" data-reveal style="background: var(--gradient-brand);">
                    <div class="blob" style="width: 260px; height: 260px; background: white; top: -100px; right: -60px;"></div>
                    <div class="position-relative">
                        <h2 class="text-white fw-bold mb-3">Prêt à rejoindre la communauté ?</h2>
                        <p class="text-white mb-4 mx-auto" style="opacity: 0.85; max-width: 480px;">
                            Créez votre compte gratuitement et commencez à partager vos compétences dès aujourd'hui.
                        </p>
                        <a href="{{ route('register') }}" class="btn btn-lg fw-semibold" style="background: white; color: var(--primary-hover); border: none; padding: 0.8125rem 1.875rem; border-radius: var(--radius-lg);">
                            Créer mon compte
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        @endunless

        <!-- Footer -->
        <footer class="py-4" style="background: var(--surface); border-top: 1px solid var(--border-light);">
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

        <script>
            const revealEls = document.querySelectorAll('[data-reveal]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            revealEls.forEach(el => observer.observe(el));
        </script>
    </body>
</html>
