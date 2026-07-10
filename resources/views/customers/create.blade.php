@extends('layouts.app')

@section('title', __('customers.add_customer'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">
        <h4 class="mb-3"><i class="bi bi-person-plus me-2"></i>{{ __('customers.add_customer') }}</h4>

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('customers.name') }}</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('customers.phone') }}</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('customers.address') }}</label>
                <textarea name="address" class="form-control">{{ old('address') }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">{{ __('customers.save') }}</button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">{{ __('customers.cancel') }}</a>
        </form>
    </div>
</div>
@endsection
