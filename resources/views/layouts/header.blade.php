<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container-fluid">
        <!-- شعار النظام -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('dashboard') }}">
            <i class="bi bi-shop fs-4 ms-2"></i>
            <span class="ms-1">{{ __('layout.app_name') }}</span>
        </a>

        <!-- زر القائمة (للأجهزة الصغيرة) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
            aria-controls="navbarMenu" aria-expanded="false" aria-label="تبديل القائمة">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
