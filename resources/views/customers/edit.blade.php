@extends('layouts.app')

@section('title', __('customers.edit_customer'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-3">


            <div class="d-flex justify-content-between align-items-center mb-4">


                <h4 class="mb-0">

                    <i class="bi bi-pencil-square text-warning me-2"></i>

                    {{ __('customers.edit_customer') }}

                </h4>



                <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">

                    <i class="bi bi-arrow-right"></i>

                    {{ __('customers.back') }}

                </a>


            </div>





            <form action="{{ route('customers.update', $customer->id) }}" method="POST">


                @csrf
                @method('PUT')



                <div class="row g-3">



                    <div class="col-md-6">


                        <label class="form-label">

                            {{ __('customers.number') }}

                        </label>


                        <input type="text" class="form-control" value="{{ $customer->customer_number }}" readonly>


                    </div>





                    <div class="col-md-6">


                        <label class="form-label">

                            {{ __('customers.name') }}

                        </label>


                        <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}"
                            required>


                    </div>





                    <div class="col-md-6">


                        <label class="form-label">

                            {{ __('customers.phone') }}

                        </label>


                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">


                    </div>





                    <div class="col-md-6">


                        <label class="form-label">

                            {{ __('customers.opening_balance') }}

                        </label>


                        <input type="number" step="0.01" name="opening_balance" class="form-control"
                            value="{{ old('opening_balance', $customer->opening_balance) }}">


                    </div>





                    <div class="col-md-6">


                        <label class="form-label">

                            {{ __('customers.credit_limit') }}

                        </label>


                        <input type="number" step="0.01" name="credit_limit" class="form-control"
                            value="{{ old('credit_limit', $customer->credit_limit) }}">


                    </div>





                    <div class="col-md-6">


                        <label class="form-label">

                            {{ __('customers.status') }}

                        </label>



                        <select name="is_active" class="form-select">



                            <option value="1" {{ old('is_active', $customer->is_active) == 1 ? 'selected' : '' }}>

                                {{ __('customers.active') }}

                            </option>




                            <option value="0" {{ old('is_active', $customer->is_active) == 0 ? 'selected' : '' }}>

                                {{ __('customers.inactive') }}

                            </option>


                        </select>


                    </div>





                    <div class="col-md-12">


                        <label class="form-label">

                            {{ __('customers.address') }}

                        </label>



                        <textarea name="address" class="form-control"
                            rows="3">{{ old('address', $customer->address) }}</textarea>


                    </div>





                    <div class="col-md-12">


                        <label class="form-label">

                            {{ __('customers.notes') }}

                        </label>



                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $customer->notes) }}</textarea>


                    </div>



                </div>





                <div class="mt-4">


                    <button type="submit" class="btn btn-primary">


                        <i class="bi bi-save"></i>

                        {{ __('customers.update') }}


                    </button>




                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">


                        {{ __('customers.cancel') }}


                    </a>


                </div>



            </form>


        </div>

    </div>


@endsection