@extends('layouts.app')

@section('title', __('payments.show_title'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">
        
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="bi bi-eye text-info me-2"></i> {{ __('payments.show_title') }}</h4>
            <div>
                <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-sm me-2">
                    <i class="bi bi-arrow-right"></i> {{ __('payments.back') }}
                </a>
               

                <a href="{{ route('payments.exportExcel') }}" class="btn btn-outline-warning btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> {{ __('payments.download_excel') }}
                </a>

            </div>
        </div>

        <!-- Payment details -->
        <table class="table table-bordered">
            <tr>
                <th>{{ __('payments.sale_id') }}</th>
                <td>{{ $payment->sale_id }}</td>
            </tr>
            <tr>
                <th>{{ __('payments.amount') }}</th>
                <td>{{ number_format($payment->amount, 2) }}</td>
            </tr>
            <tr>
                <th>{{ __('payments.payment_date') }}</th>
                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d H:i') }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
