<x-app-layout>
    <x-slot name="header">
        <h1 class="page-title">
            <i class="bi bi-person"></i>
            Mon profil
        </h1>
    </x-slot>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 mb-4" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card border-0 mb-4" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body-lg">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0" style="box-shadow: var(--shadow-sm);">
                <div class="card-body text-center p-4">
                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil" class="rounded-circle mb-3" style="width: 96px; height: 96px; object-fit: cover; border: 3px solid var(--border-light);">
                    @else
                        <div class="avatar avatar-xl avatar-primary mx-auto mb-3">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-2" style="font-size: 0.875rem;">{{ $user->email }}</p>
                    @if ($user->city)
                        <div class="text-muted" style="font-size: 0.8125rem;"><i class="bi bi-geo-alt me-1"></i>{{ $user->city }}</div>
                    @endif
                    @if ($user->bio)
                        <p class="text-muted mt-2" style="font-size: 0.8125rem; line-height: 1.5;">{{ $user->bio }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
