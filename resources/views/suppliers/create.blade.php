@extends('layouts.app')

@section('title', __('suppliers.add_supplier'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-3">


            <h4 class="mb-4">
                <i class="bi bi-plus-square text-success me-2"></i>
                {{ __('suppliers.add_supplier') }}
            </h4>



            <form action="{{ route('suppliers.store') }}" method="POST">

                @csrf



                <div class="row g-3">


                    <div class="col-md-6">

                        <label class="form-label">
                            {{ __('suppliers.name') }}
                        </label>

                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>

                    </div>




                    <div class="col-md-6">

                        <label class="form-label">
                            {{ __('suppliers.company') }}
                        </label>

                        <input type="text" name="company" class="form-control" value="{{ old('company') }}">

                    </div>




                    <div class="col-md-6">

                        <label class="form-label">
                            {{ __('suppliers.phone') }}
                        </label>

                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">

                    </div>




                    <div class="col-md-6">

                        <label class="form-label">
                            {{ __('suppliers.opening_balance') }}
                        </label>

                        <input type="number" step="0.01" name="opening_balance" class="form-control"
                            value="{{ old('opening_balance') }}">

                    </div>




                    <div class="col-md-12">

                        <label class="form-label">
                            {{ __('suppliers.address') }}
                        </label>

                        <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>

                    </div>




                    <div class="col-md-12">

                        <label class="form-label">
                            {{ __('suppliers.note') }}
                        </label>

                        <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>

                    </div>


                </div>




                <div class="mt-4">

                    <button class="btn btn-success">

                        <i class="bi bi-check-circle"></i>

                        {{ __('suppliers.save') }}

                    </button>


                    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">

                        {{ __('suppliers.cancel') }}

                    </a>

                </div>



            </form>


        </div>

    </div>

@endsection