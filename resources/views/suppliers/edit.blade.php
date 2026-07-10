@extends('layouts.app')

@section('title', __('suppliers.edit_supplier'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">
        <h4 class="mb-3">
            <i class="bi bi-pencil-square me-2 text-warning"></i>
            {{ __('suppliers.edit_supplier') }}
        </h4>

        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">{{ __('suppliers.name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $supplier->name) }}" required>
                @error('name')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('suppliers.company') }}</label>
                <input type="text" name="company" class="form-control" value="{{ old('company', $supplier->company) }}">
                @error('company')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('suppliers.phone') }}</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}">
                @error('phone')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('suppliers.address') }}</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $supplier->address) }}</textarea>
                @error('address')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-start gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> {{ __('suppliers.update') }}
                </button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right-circle me-1"></i> {{ __('suppliers.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
