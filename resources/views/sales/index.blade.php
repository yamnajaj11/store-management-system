@extends('layouts.app')

@section('title', __('sales.title'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-receipt text-primary me-2"></i> {{ __('sales.title') }}
            </h4>
            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> {{ __('sales.add') }}
            </a>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('sales.customer') }}</th>
                        <th>{{ __('sales.total') }}</th>
                        <th>{{ __('sales.status') }}</th>
                        <th>{{ __('sales.date') }}</th>
                        <th>{{ __('sales.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->customer->name ?? '-' }}</td>
                            <td>{{ number_format($sale->total_amount, 2) }}</td>
                            <td>
                                @if($sale->status === 'مدفوع')
                                    <span class="badge bg-success">{{ $sale->status }}</span>
                                @elseif($sale->status === 'مدفوع جزئي')
                                    <span class="badge bg-warning text-dark">{{ $sale->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $sale->status }}</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted py-4">{{ __('sales.no_sales') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
