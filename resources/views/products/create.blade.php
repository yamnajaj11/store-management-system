@extends('layouts.app')

@section('title', __('products.add_product'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-4 border">


            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4 class="mb-0 text-primary fw-bold">

                    <i class="bi bi-box-seam me-2"></i>

                    {{ __('products.add_product') }}

                </h4>


                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">

                    <i class="bi bi-arrow-left"></i>

                    {{ __('products.back') }}

                </a>


            </div>



            <form action="{{ route('products.store') }}" method="POST">

                @csrf



                <div class="card border-0 shadow-sm">


                    <div class="card-body">


                        <h5 class="text-secondary fw-bold mb-4">

                            <i class="bi bi-info-circle me-2"></i>

                            {{ __('products.product_details') }}

                        </h5>




                        <div class="row g-3">



                            <div class="col-md-6">


                                <label class="form-label fw-semibold">

                                    {{ __('products.name') }}

                                </label>


                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>


                            </div>





                            <div class="col-md-3">


                                <label class="form-label fw-semibold">

                                    {{ __('products.unit') }}

                                </label>


                                <input type="text" name="unit" class="form-control" value="{{ old('unit') }}" required>


                            </div>





                            <div class="col-md-3">


                                <label class="form-label fw-semibold">

                                    {{ __('products.supplier') }}

                                </label>


                                <select name="supplier_id" class="form-select" required>


                                    <option value="">

                                        {{ __('products.choose_supplier') }}

                                    </option>


                                    @foreach($suppliers as $supplier)

                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>

                                            {{ $supplier->name }}

                                        </option>

                                    @endforeach


                                </select>


                            </div>





                            <div class="col-12">


                                <label class="form-label fw-semibold">

                                    {{ __('products.description') }}

                                </label>


                                <textarea name="description" class="form-control"
                                    rows="3">{{ old('description') }}</textarea>


                            </div>



                        </div>


                    </div>


                </div>






                <div class="mt-4 text-end">


                    <button class="btn btn-primary px-4">


                        <i class="bi bi-check-circle me-1"></i>

                        {{ __('products.save') }}


                    </button>



                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">

                        <i class="bi bi-x-circle me-1"></i>

                        {{ __('products.cancel') }}

                    </a>


                </div>



            </form>



        </div>


    </div>


@endsection