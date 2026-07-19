@extends('layouts.app')

@section('title', __('purchase_returns.show_title'))

@section('content')

    <div class="container-fluid">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-body p-4">


                <div class="d-flex justify-content-between align-items-center mb-4">


                    <div>

                        <h4 class="fw-bold mb-1">

                            <i class="bi bi-eye text-primary"></i>

                            {{ __('purchase_returns.show_title') }}

                        </h4>


                        <small class="text-muted">

                            {{ $return->return_number }}

                        </small>
                    </div>




                    <a href="{{ route('purchase_returns.index') }}" class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>

                        {{ __('purchase_returns.back') }}

                    </a>


                </div>







                <div class="card bg-light border-0 rounded-4 mb-4">


                    <div class="card-body">


                        <div class="row g-3">


                            <div class="col-md-4">

                                <label class="form-label fw-bold">
                                    {{ __('purchase_returns.return_number') }}
                                </label>

                                <input class="form-control" value="{{ $return->return_number }}" readonly>

                            </div>




                            <div class="col-md-4">


                                <label class="form-label fw-bold">

                                    {{ __('purchase_returns.supplier') }}

                                </label>


                                <input class="form-control" value="{{ $return->supplier->name }}" readonly>


                            </div>





                            <div class="col-md-4">


                                <label class="form-label fw-bold">

                                    {{ __('purchase_returns.return_date') }}

                                </label>


                                <input class="form-control" value="{{ $return->return_date->format('Y-m-d') }}" readonly>


                            </div>



                        </div>


                    </div>


                </div>







                <div class="card shadow-sm rounded-4">


                    <div class="card-body">



                        <h5 class="fw-bold mb-3">


                            <i class="bi bi-box-seam"></i>


                            {{ __('purchase_returns.items') }}


                        </h5>






                        <div class="table-responsive">


                            <table class="table table-bordered text-center align-middle">


                                <thead class="table-light">


                                    <tr>


                                        <th>

                                            {{ __('purchase_returns.product') }}

                                        </th>



                                        <th>

                                            {{ __('purchase_returns.return_quantity') }}

                                        </th>



                                        <th>

                                            {{ __('purchase_returns.amount') }}

                                        </th>



                                    </tr>


                                </thead>






                                <tbody>


                                    @foreach($return->items as $item)


                                        <tr>


                                            <td>

                                                {{ $item->product->name }}

                                            </td>



                                            <td>

                                                {{ $item->quantity }}

                                            </td>



                                            <td>

                                                {{ $item->subtotal }}

                                            </td>


                                        </tr>


                                    @endforeach



                                </tbody>






                                <tfoot>


                                    <tr>


                                        <th colspan="2">

                                            {{ __('purchase_returns.total') }}

                                        </th>


                                        <th>

                                            {{ $return->total_amount }}

                                        </th>


                                    </tr>


                                </tfoot>



                            </table>


                        </div>



                    </div>


                </div>








                <div class="card bg-light border-0 rounded-4 mt-4">


                    <div class="card-body">


                        <label class="form-label fw-bold">

                            {{ __('purchase_returns.notes') }}

                        </label>


                        <textarea class="form-control" rows="3" readonly>{{ $return->note }}</textarea>


                    </div>


                </div>





            </div>

        </div>

    </div>


@endsection