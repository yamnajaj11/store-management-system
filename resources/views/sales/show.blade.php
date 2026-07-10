@extends('layouts.app')

@section('title', __('sales.show'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-receipt text-primary me-2"></i>
                {{ __('sales.invoice_number') }} #{{ $sale->id }}
            </h4>
            <div>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm me-2">
                    <i class="bi bi-arrow-right"></i> {{ __('sales.back') }}
                </a>
                <a href="{{ route('sales.exportExcel') }}" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> {{ __('sales.download_excel') }}
                </a>
            </div>
        </div>

        <!-- Info -->
        <div class="row mb-4">
            <div class="col-md-4">
                <h6 class="text-muted">{{ __('sales.customer') }}:</h6>
                <p>{{ $sale->customer->name ?? 'عميل عام' }}</p>
            </div>
            <div class="col-md-4">
                <h6 class="text-muted">{{ __('sales.date') }}:</h6>
                <p>{{ \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d H:i') }}</p>
            </div>
            <div class="col-md-4">
                <h6 class="text-muted">{{ __('sales.status') }}:</h6>
                <span class="badge 
                    @if($sale->status === 'مدفوع') bg-success 
                    @elseif($sale->status === 'مدفوع جزئي') bg-warning 
                    @else bg-danger @endif">
                    {{ $sale->status }}
                </span>
            </div>
        </div>

        <!-- Items -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('sales.product') }}</th>
                        <th>{{ __('sales.quantity') }}</th>
                        <th>{{ __('sales.price') }}</th>
                        <th>{{ __('sales.subtotal') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product->name ?? '-' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="fw-bold">
                    <tr>
                        <td colspan="4" class="text-end">{{ __('sales.total') }}:</td>
                        <td>{{ number_format($sale->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end">{{ __('sales.paid_amount') }}:</td>
                        <td>{{ number_format($sale->paid_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end">{{ __('sales.remaining_amount') }}:</td>
                        <td>{{ number_format($sale->remaining_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Notes -->
        <div class="mt-4">
            <h6 class="text-muted">{{ __('sales.notes') }}:</h6>
            <p class="text-secondary">
                {{ __('sales.thank_you') }} <br>
                {{ __('sales.print_hint') }}
            </p>
        </div>
    </div>
</div>
@endsection
