@extends('layouts.app')

@section('title', __('customers.edit_customer'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">
        <h4 class="mb-3"><i class="bi bi-pencil-square me-2"></i>{{ __('customers.edit_customer') }}</h4>

        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">{{ __('customers.name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('customers.phone') }}</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('customers.address') }}</label>
                <textarea name="address" class="form-control">{{ old('address', $customer->address) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('customers.update') }}</button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">{{ __('customers.cancel') }}</a>
        </form>
    </div>
</div>
@endsection
