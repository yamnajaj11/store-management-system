@extends('layouts.app')

@section('title', __('dashboard.title'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 rounded-3 shadow-sm">
        <h3 class="fw-bold mb-2">{{ __('dashboard.title') }}</h3>
        <p class="text-muted">{{ __('dashboard.welcome') }}</p>

        <hr>

        <h5 class="mb-3">{{ __('dashboard.statistics') }}</h5>

        <div class="row g-3">
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-people display-5 text-primary"></i>
                        <h6 class="mt-2">{{ __('dashboard.total_customers') }}</h6>
                        <p class="fs-4 fw-bold mb-0">{{ number_format($stats['customers'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-truck display-5 text-success"></i>
                        <h6 class="mt-2">{{ __('dashboard.total_suppliers') }}</h6>
                        <p class="fs-4 fw-bold mb-0">{{ number_format($stats['suppliers'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-box-seam display-5 text-warning"></i>
                        <h6 class="mt-2">{{ __('dashboard.total_products') }}</h6>
                        <p class="fs-4 fw-bold mb-0">{{ number_format($stats['products'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-receipt display-5 text-info"></i>
                        <h6 class="mt-2">{{ __('dashboard.total_sales') }}</h6>
                        <p class="fs-4 fw-bold mb-0">{{ number_format($stats['sales'] ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-cash-coin display-5 text-danger"></i>
                        <h6 class="mt-2">{{ __('dashboard.total_payments') }}</h6>
                        <p class="fs-4 fw-bold mb-0">{{ number_format($stats['payments'] ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
