@if (session('success'))
    <div class="alert alert-success d-flex align-items-center fade-in" role="alert">
        <i class="bi bi-check-circle-fill me-2 flex-shrink-0"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger d-flex align-items-center fade-in" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger fade-in" role="alert">
        <div class="d-flex align-items-center mb-2">
            <i class="bi bi-exclamation-circle-fill me-2 flex-shrink-0"></i>
            <strong style="font-size: 0.875rem;">Veuillez corriger les erreurs suivantes</strong>
        </div>
        <ul class="mb-0 ps-3" style="font-size: 0.8125rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
