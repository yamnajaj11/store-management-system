@extends('layouts.app')

@section('title', __('suppliers.add_supplier'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">
        <h4 class="mb-3">
            <i class="bi bi-plus-square me-2 text-success"></i>
            {{ __('suppliers.add_supplier') }}
        </h4>

        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('suppliers.name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('suppliers.company') }}</label>
                <input type="text" name="company" class="form-control" value="{{ old('company') }}">
                @error('company')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('suppliers.phone') }}</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                @error('phone')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('suppliers.address') }}</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                @error('address')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-start gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check2-circle me-1"></i> {{ __('suppliers.save') }}
                </button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> {{ __('suppliers.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
