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
        <div class="d-flex min-vh-100 flex-column">
            @include('layouts.navigation')

            <div class="flex-grow-1">
                @isset($header)
                    <div class="content-wrapper" style="padding-bottom: 0;">
                        <div class="page-header">
                            {{ $header }}
                        </div>
                    </div>
                @endisset

                <div class="content-wrapper fade-in">
                    @include('layouts.flash')
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>

            @include('layouts.footer')
        </div>

        @stack('scripts')
    </body>
</html>
