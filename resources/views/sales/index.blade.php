@extends('layouts.app')

@section('title', __('sales.title'))

@section('content')

    <div class="container-fluid">

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">


            {{-- Header --}}
            <div class="card-header bg-white border-0 p-4">

                <div class="d-flex justify-content-between align-items-center">


                    <div>

                        <h4 class="mb-1 fw-bold">

                            <i class="bi bi-receipt-cutoff text-primary me-2"></i>

                            {{ __('sales.title') }}

                        </h4>


                        <small class="text-muted">

                            {{ __('sales.description') }}

                        </small>


                    </div>




                    <a href="{{ route('sales.create') }}" class="btn btn-primary px-4 rounded-3">


                        <i class="bi bi-plus-circle me-1"></i>

                        {{ __('sales.add') }}


                    </a>


                </div>


            </div>





            {{-- Body --}}
            <div class="card-body p-4">



                <div class="table-responsive">


                    <table class="table table-hover align-middle text-center">



                        <thead class="table-light">


                            <tr>




                                <th>
                                    {{ __('sales.customer') }}
                                </th>


                                <th>
                                    {{ __('sales.invoice_number') }}
                                </th>


                                <th>
                                    المبلغ النهائي
                                </th>


                                <th>
                                    المدفوع
                                </th>


                                <th>
                                    المتبقي
                                </th>


                                <th>
                                    {{ __('sales.status') }}
                                </th>


                                <th>
                                    {{ __('sales.date') }}
                                </th>


                                <th>
                                    {{ __('sales.actions') }}
                                </th>


                            </tr>


                        </thead>





                        <tbody>



                            @forelse($sales as $sale)



                                <tr>


                                    <td>

                                        <div class="fw-semibold">

                                            {{ $sale->customer->name ?? '-' }}

                                        </div>

                                    </td>





                                    <td>

                                        <span class="badge bg-light text-dark">

                                            {{ $sale->invoice_number }}

                                        </span>

                                    </td>





                                    <td>

                                        <span class="fw-bold text-primary">

                                            {{ number_format($sale->final_amount, 2, '.', '') }}

                                        </span>

                                    </td>





                                    <td>

                                        <span class="fw-bold text-success">

                                            {{ number_format($sale->paid_amount, 2, '.', '') }}

                                        </span>

                                    </td>





                                    <td>

                                        <span class="fw-bold text-danger">

                                            {{ number_format($sale->remaining_amount, 2, '.', '') }}

                                        </span>

                                    </td>







                                    <td>



                                        @if($sale->status == 'مدفوع')


                                            <span class="badge rounded-pill bg-success-subtle text-success px-3">

                                                {{ $sale->status }}

                                            </span>



                                        @elseif($sale->status == 'مدفوع جزئي')



                                            <span class="badge rounded-pill bg-warning-subtle text-warning px-3">

                                                {{ $sale->status }}

                                            </span>



                                        @else



                                            <span class="badge rounded-pill bg-danger-subtle text-danger px-3">

                                                {{ $sale->status }}

                                            </span>



                                        @endif



                                    </td>






                                    <td>


                                        <span class="text-muted">


                                            {{ \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') }}


                                        </span>


                                    </td>







                                    <td>



                                        <div class="btn-group">





                                            {{-- View --}}

                                            <a href="{{ route('sales.show', $sale->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="{{ __('sales.show') }}">


                                                <i class="bi bi-eye"></i>


                                            </a>






                                            {{-- Edit --}}

                                            <a href="{{ route('sales.edit', $sale->id) }}"
                                                class="btn btn-sm btn-outline-warning" title="{{ __('sales.edit') }}">


                                                <i class="bi bi-pencil"></i>


                                            </a>








                                            {{-- Delete --}}

                                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                                class="d-inline">


                                                @csrf

                                                @method('DELETE')



                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('{{ __('sales.confirm_delete') }}')"
                                                    title="{{ __('sales.delete') }}">


                                                    <i class="bi bi-trash"></i>


                                                </button>



                                            </form>




                                        </div>


                                    </td>




                                </tr>





                            @empty



                                <tr>


                                    <td colspan="9" class="py-5 text-muted">


                                        <i class="bi bi-receipt fs-1 d-block mb-3"></i>


                                        {{ __('sales.no_sales') }}



                                    </td>


                                </tr>



                            @endforelse





                        </tbody>



                    </table>



                </div>



                @if(method_exists($sales, 'links'))

                    <div class="mt-3">

                        {{ $sales->links() }}

                    </div>

                @endif



            </div>


        </div>


    </div>


@endsection