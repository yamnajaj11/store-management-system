@extends('layouts.app')

@section('title', __('payments.index_title'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="bi bi-cash-stack text-success me-2"></i> {{ __('payments.index_title') }}</h4>
            <a href="{{ route('payments.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> {{ __('payments.create_new') }}
            </a>
        </div>

        @if($payments->isEmpty())
            <div class="alert alert-info text-center">{{ __('payments.no_payments') }}</div>
        @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('payments.sale_id') }}</th>
                        <th>{{ __('payments.amount') }}</th>
                        <th>{{ __('payments.payment_date') }}</th>
                        <th>{{ __('payments.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payment->sale_id }}</td>
                            <td>{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('هل أنت متأكد من حذف هذا العميل؟')" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
