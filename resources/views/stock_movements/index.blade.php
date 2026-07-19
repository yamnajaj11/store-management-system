@extends('layouts.app')

@section('title', __('stock_movements.title'))

@section('content')

    <div class="container-fluid">


        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">


            {{-- Header --}}
            <div class="card-header bg-white border-0 p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <h4 class="fw-bold mb-0">

                        <i class="bi bi-arrow-left-right text-primary me-2"></i>

                        {{ __('stock_movements.title') }}

                    </h4>


                </div>

            </div>



            <div class="card-body p-4">



                {{-- Filters --}}

                <form method="GET" class="row g-3 mb-4">


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">

                            {{ __('stock_movements.date') }}

                        </label>


                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">


                    </div>





                    <div class="col-md-4">


                        <label class="form-label fw-semibold">

                            {{ __('stock_movements.direction') }}

                        </label>



                        <select name="direction" class="form-select">


                            <option value="">

                                {{ __('stock_movements.all') }}

                            </option>


                            <option value="in" @selected(request('direction') == 'in')>

                                {{ __('stock_movements.in') }}

                            </option>



                            <option value="out" @selected(request('direction') == 'out')>

                                {{ __('stock_movements.out') }}

                            </option>


                        </select>


                    </div>






                    <div class="col-md-4 d-flex align-items-end">


                        <button class="btn btn-primary me-2">

                            <i class="bi bi-search"></i>

                            {{ __('stock_movements.filter') }}

                        </button>




                        <a href="{{ route('stock_movements.index') }}" class="btn btn-secondary">


                            {{ __('stock_movements.reset') }}


                        </a>


                    </div>



                </form>








                {{-- Statistics --}}

                <div class="row g-3 mb-4">


                    <div class="col-md-4">

                        <div class="bg-light rounded-4 p-3 text-center">


                            <small class="text-muted d-block">

                                {{ __('stock_movements.title') }}

                            </small>


                            <h4 class="fw-bold mb-0">

                                {{ $movements->count() }}

                            </h4>


                        </div>


                    </div>





                    <div class="col-md-4">


                        <div class="bg-light rounded-4 p-3 text-center">


                            <small class="text-muted d-block">

                                {{ __('stock_movements.in') }}

                            </small>


                            <h4 class="fw-bold text-success mb-0">


                                {{ $movements->where('quantity', '>', 0)->count() }}


                            </h4>


                        </div>


                    </div>






                    <div class="col-md-4">


                        <div class="bg-light rounded-4 p-3 text-center">


                            <small class="text-muted d-block">

                                {{ __('stock_movements.out') }}

                            </small>


                            <h4 class="fw-bold text-danger mb-0">


                                {{ $movements->where('quantity', '<', 0)->count() }}


                            </h4>


                        </div>


                    </div>



                </div>









                @if($movements->isEmpty())


                    <div class="alert alert-info text-center">

                        {{ __('stock_movements.no_movements') }}

                    </div>


                @else




                    <div class="table-responsive">


                        <table class="table table-hover table-bordered align-middle text-center">


                            <thead class="table-light">


                                <tr>


                                    <th>#</th>


                                    <th>

                                        {{ __('stock_movements.date') }}

                                    </th>



                                    <th>

                                        {{ __('stock_movements.product') }}

                                    </th>



                                    <th>

                                        {{ __('stock_movements.type') }}

                                    </th>



                                    <th>

                                        {{ __('stock_movements.quantity') }}

                                    </th>



                                    <th>

                                        {{ __('stock_movements.stock_after') }}

                                    </th>



                                    <th>

                                        {{ __('stock_movements.reference') }}

                                    </th>


                                </tr>


                            </thead>





                            <tbody>


                                @foreach($movements as $movement)



                                    <tr>


                                        <td>

                                            {{ $loop->iteration }}

                                        </td>





                                        <td>


                                            <span class="text-muted">


                                                {{ $movement->created_at->format('Y-m-d') }}

                                                <br>

                                                {{ $movement->created_at->format('H:i') }}


                                            </span>


                                        </td>






                                        <td class="fw-semibold">


                                            {{ $movement->product->name ?? '-' }}


                                        </td>







                                        <td>


                                            @if($movement->quantity > 0)


                                                <span class="badge bg-success rounded-pill px-3">

                                                    ↑ {{ __('stock_movements.in') }}

                                                </span>


                                            @else


                                                <span class="badge bg-danger rounded-pill px-3">

                                                    ↓ {{ __('stock_movements.out') }}

                                                </span>


                                            @endif



                                            <br>



                                            <small class="text-muted">


                                                {{ __('stock_movements.' . $movement->type) ?? $movement->type }}


                                            </small>


                                        </td>







                                        <td>


                                            @if($movement->quantity > 0)


                                                <span class="text-success fw-bold fs-6">

                                                    +{{ $movement->quantity }}

                                                </span>


                                            @else


                                                <span class="text-danger fw-bold fs-6">

                                                    {{ $movement->quantity }}

                                                </span>


                                            @endif


                                        </td>







                                        <td>


                                            <span class="badge bg-secondary rounded-pill px-3">


                                                {{ $movement->stock_after }}


                                            </span>


                                        </td>








                                        <td>


                                            @if($movement->reference)



                                                <span class="badge bg-primary rounded-pill px-3">


                                                    @if(isset($movement->reference->invoice_number))


                                                        {{ $movement->reference->invoice_number }}


                                                    @else


                                                        #{{ $movement->reference_id }}


                                                    @endif



                                                </span>


                                            @else


                                                -


                                            @endif


                                        </td>






                                    </tr>



                                @endforeach



                            </tbody>



                        </table>



                    </div>




                @endif





            </div>


        </div>


    </div>


@endsection