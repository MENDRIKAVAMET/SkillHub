<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SkillHub') }}</title>
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
        <div class="min-vh-100 d-flex">
            <!-- Panneau visuel de marque -->
            <div class="d-none d-lg-flex col-lg-5 position-relative overflow-hidden flex-column justify-content-between p-5"
                 style="background: var(--gradient-brand);">
                <div class="blob" style="width: 320px; height: 320px; background: white; top: -80px; left: -80px;"></div>
                <div class="blob" style="width: 280px; height: 280px; background: #fbcfe8; bottom: -60px; right: -60px; animation-delay: -6s;"></div>
                <div class="position-absolute top-0 start-0 w-100 h-100 grid-pattern"></div>

                <a href="/" class="text-decoration-none position-relative">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 38px; height: 38px; background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.3); border-radius: var(--radius-md); display:flex; align-items:center; justify-content:center; backdrop-filter: blur(6px);">
                            <i class="bi bi-lightning-charge-fill text-white"></i>
                        </div>
                        <span class="fw-bold text-white" style="font-family: var(--font-display); font-size: 1.25rem; letter-spacing: -0.02em;">SkillHub</span>
                    </div>
                </a>

                <div class="position-relative">
                    <div class="mb-3" style="display:inline-flex; align-items:center; gap:0.5rem; background: rgba(255,255,255,0.15); padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.8125rem; color: rgba(255,255,255,0.9);">
                        <i class="bi bi-stars"></i> Communauté d'entraide
                    </div>
                    <h2 class="text-white fw-bold mb-3" style="font-size: 2rem; line-height: 1.25; letter-spacing: -0.02em;">
                        Apprenez. Partagez.<br>Progressez ensemble.
                    </h2>
                    <p class="text-white mb-0" style="opacity: 0.85; max-width: 380px; line-height: 1.7;">
                        Rejoignez une communauté où chaque compétence partagée en fait grandir une autre.
                    </p>
                </div>

                <div class="position-relative text-white" style="opacity: 0.7; font-size: 0.8125rem;">
                    &copy; {{ date('Y') }} SkillHub — Plateforme collaborative de partage de compétences
                </div>
            </div>

            <!-- Panneau formulaire -->
            <div class="col-lg-7 col-12 d-flex flex-column justify-content-center align-items-center px-4 py-5 position-relative" style="background: var(--background);">
                <button type="button" class="theme-toggle position-absolute" style="top: 1.5rem; right: 1.5rem;" data-theme-toggle aria-label="Basculer le thème sombre">
                    <span class="theme-toggle-knob"><i class="bi bi-sun-fill" data-theme-icon></i></span>
                </button>

                <div class="d-lg-none mb-4">
                    <a href="/" class="text-decoration-none">
                        <div class="d-flex align-items-center gap-2">
                            <div class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                            <span class="fw-bold" style="font-family: var(--font-display); font-size: 1.25rem; color: var(--text);">SkillHub</span>
                        </div>
                    </a>
                </div>

                <div class="w-100 fade-in" style="max-width: 26rem;">
                    <div class="card border-0" style="box-shadow: var(--shadow-lg);">
                        <div class="card-body p-4 p-md-5">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
