@extends('layouts.app')

@section('title', __('products.product_details'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-4 border">


            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4 class="mb-0 text-primary fw-bold">

                    <i class="bi bi-box-seam me-2"></i>

                    {{ __('products.product_details') }}

                </h4>



                <div>

                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">

                        <i class="bi bi-pencil-square"></i>

                        {{ __('products.edit') }}

                    </a>


                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">

                        <i class="bi bi-arrow-left"></i>

                        {{ __('products.back') }}

                    </a>

                </div>

            </div>



            <div class="row g-3">



                <div class="col-md-6">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">
                            {{ __('products.name') }}
                        </h6>


                        <p class="fs-5 fw-semibold mb-0">
                            {{ $product->name }}
                        </p>


                    </div>

                </div>




                <div class="col-md-6">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">
                            {{ __('products.suppliers') }}
                        </h6>


                        <div>

                            @forelse($product->suppliers as $supplier)

                                <span class="badge bg-info text-dark me-1">

                                    {{ $supplier->name }}

                                </span>

                            @empty

                                —

                            @endforelse

                        </div>


                    </div>

                </div>





                <div class="col-md-6">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">
                            {{ __('products.unit') }}
                        </h6>


                        <p class="fs-5 fw-semibold mb-0">

                            {{ $product->unit ?? '—' }}

                        </p>


                    </div>

                </div>





                <div class="col-md-6">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">

                            الباركود

                        </h6>


                        <p class="fs-5 fw-semibold mb-0">

                            {{ $product->barcode ?? '—' }}

                        </p>


                    </div>

                </div>





                <div class="col-12">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">

                            {{ __('products.description') }}

                        </h6>


                        <p class="mb-0">

                            {{ $product->description ?? '—' }}

                        </p>


                    </div>

                </div>



            </div>


        </div>

    </div>

@endsection