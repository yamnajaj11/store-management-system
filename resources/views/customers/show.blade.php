@extends('layouts.app')

@section('title', __('customers.customer_details'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">

        <!-- العنوان -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">
                <i class="bi bi-person-circle me-2 text-primary"></i>
                {{ __('customers.customer_details') }}
            </h4>

            <div>
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i> {{ __('customers.edit') }}
                </a>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-right-circle"></i> {{ __('customers.back') }}
                </a>
            </div>
        </div>

        <!-- تفاصيل العميل -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-3 border rounded bg-light">
                    <h6 class="text-muted">{{ __('customers.name') }}</h6>
                    <p class="fs-5 fw-semibold mb-0">{{ $customer->name }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 border rounded bg-light">
                    <h6 class="text-muted">{{ __('customers.phone') }}</h6>
                    <p class="fs-5 fw-semibold mb-0">{{ $customer->phone ?? '-' }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 border rounded bg-light">
                    <h6 class="text-muted">{{ __('customers.address') }}</h6>
                    <p class="fs-5 fw-semibold mb-0">{{ $customer->address ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- المبيعات الخاصة بالعميل -->
        <hr class="my-4">

        <h5 class="mb-3">
            <i class="bi bi-receipt me-2"></i>{{ __('customers.customer_sales') }}
        </h5>

        @if($customer->sales->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('customers.sale_date') }}</th>
                            <th>{{ __('customers.total_amount') }}</th>
                            <th>{{ __('customers.paid_amount') }}</th>
                            <th>{{ __('customers.remaining_amount') }}</th>
                            <th>{{ __('customers.status') }}</th>
                            <th>{{ __('customers.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->sale_date }}</td>
                                <td>{{ number_format($sale->total_amount, 2) }}</td>
                                <td>{{ number_format($sale->paid_amount, 2) }}</td>
                                <td>{{ number_format($sale->remaining_amount, 2) }}</td>
                                <td>
                                    @if($sale->is_paid)
                                        <span class="badge bg-success">{{ __('customers.paid') }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ __('customers.unpaid') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- مجموع كل المبيعات -->
            @php
                $totalSales = $customer->sales->sum('total_amount');
                $totalPaid = $customer->sales->sum(fn($s) => $s->paid_amount);
                $totalRemaining = $totalSales - $totalPaid;
            @endphp

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light text-center">
                        <h6 class="text-muted">{{ __('customers.total_sales') }}</h6>
                        <p class="fs-5 fw-semibold text-primary mb-0">{{ number_format($totalSales, 2) }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light text-center">
                        <h6 class="text-muted">{{ __('customers.total_paid') }}</h6>
                        <p class="fs-5 fw-semibold text-success mb-0">{{ number_format($totalPaid, 2) }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light text-center">
                        <h6 class="text-muted">{{ __('customers.total_remaining') }}</h6>
                        <p class="fs-5 fw-semibold text-danger mb-0">{{ number_format($totalRemaining, 2) }}</p>
                    </div>
                </div>
            </div>
        @else
            <p class="text-muted">{{ __('customers.no_sales_for_customer') }}</p>
        @endif
    </div>
</div>
@endsection
