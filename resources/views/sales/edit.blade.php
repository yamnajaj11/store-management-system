@extends('layouts.app')

@section('title', __('sales.edit'))

@section('content')

<div class="container-fluid">

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">


<div class="card-header bg-white border-0 p-4">

<div class="d-flex align-items-center">


<div class="bg-warning-subtle rounded-3 p-3 me-3">

<i class="bi bi-pencil-square fs-3 text-warning"></i>

</div>


<div>

<h4 class="mb-1 fw-bold">

{{ __('sales.edit') }}

</h4>


<small class="text-muted">

تعديل الكمية والخصومات فقط

</small>


</div>


</div>

</div>





<div class="card-body p-4">



@if(session('error'))

<div class="alert alert-danger">

<i class="bi bi-exclamation-triangle me-2"></i>

{{ session('error') }}

</div>

@endif




@if($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif






<form action="{{ route('sales.update',$sale->id) }}" method="POST">

@csrf

@method('PUT')






{{-- معلومات الفاتورة --}}


<div class="card border-0 bg-light rounded-4 mb-4">


<div class="card-body">


<h5 class="fw-bold mb-3">

<i class="bi bi-info-circle text-warning me-2"></i>

معلومات الفاتورة

</h5>





<div class="row g-3">





<div class="col-md-5">


<label class="form-label fw-semibold">

{{ __('sales.customer') }}

</label>


<input type="hidden"
name="customer_id"
value="{{ $sale->customer_id }}">



<input type="text"
class="form-control"
value="{{ $sale->customer->name ?? 'عميل عام' }}"
readonly>


</div>






<div class="col-md-3">


<label class="form-label fw-semibold">

{{ __('sales.date') }}

</label>


<input type="hidden"
name="sale_date"
value="{{ $sale->sale_date->format('Y-m-d') }}">


<input type="text"
class="form-control"
value="{{ $sale->sale_date->format('Y-m-d') }}"
readonly>


</div>






<div class="col-md-2">


<label class="form-label fw-semibold">

{{ __('sales.status') }}

</label>


<input type="hidden"
name="status"
value="{{ $sale->status }}">


<input type="text"
class="form-control"
value="{{ $sale->status }}"
readonly>


</div>






<div class="col-md-2">


<label class="form-label fw-semibold">

{{ __('sales.discount') }}

</label>



<input type="number"

name="discount"

id="invoiceDiscount"

class="form-control"

value="{{ $sale->discount }}"

min="0"

max="100">


</div>



</div>


</div>


</div>








{{-- المنتجات --}}


<div class="card border rounded-4 mb-4">


<div class="card-header bg-light">


<h6 class="mb-0 fw-bold">

<i class="bi bi-box-seam text-warning me-2"></i>

{{ __('sales.items') }}

</h6>


</div>





<div class="card-body">


<div class="table-responsive">


<table class="table table-bordered text-center align-middle">


<thead class="table-light">


<tr>

<th>
المنتج
</th>

<th>
المخزون
</th>

<th>
الكمية
</th>

<th>
السعر
</th>

<th>
خصم %
</th>

<th>
الإجمالي
</th>

</tr>


</thead>




<tbody id="itemsBody">



@foreach($sale->items as $index=>$item)


<tr>



<td>


<input type="hidden"

name="items[{{$index}}][product_id]"

value="{{ $item->product_id }}">



<input type="text"

class="form-control"

value="{{ $item->product->name ?? '-' }}"

readonly>


</td>





<td>


<input type="text"

class="form-control"

value="{{ $item->product->stock ?? 0 }}"

readonly>


</td>






<td>


<input type="number"

name="items[{{$index}}][quantity]"

class="form-control quantity"

value="{{ $item->quantity }}"

min="1"

required>


</td>






<td>


<input type="hidden"

name="items[{{$index}}][unit_price]"

value="{{ $item->unit_price }}">



<input type="number"

class="form-control price"

value="{{ $item->unit_price }}"

readonly>


</td>






<td>


<input type="number"

name="items[{{$index}}][discount]"

class="form-control discount"

value="{{ $item->discount }}"

min="0"

max="100">


</td>






<td>


<input type="text"

class="form-control subtotal"

value="{{ number_format($item->subtotal,2,'.','') }}"

readonly>


</td>



</tr>



@endforeach



</tbody>


</table>


</div>


</div>


</div>
{{-- الحسابات --}}

<div class="card border-0 bg-light rounded-4 mb-4">


<div class="card-body text-end">



<div class="mb-2">

المجموع قبل الخصم :

<span id="beforeDiscount" class="fw-bold">
0.00
</span>

{{ __('sales.currency') }}

</div>





<div class="mb-2 text-danger">

خصم المنتجات :

<span id="itemsDiscount" class="fw-bold">
0.00
</span>

{{ __('sales.currency') }}

</div>





<div class="mb-2 text-danger">

خصم الفاتورة :

<span id="invoiceDiscountAmount" class="fw-bold">
0.00
</span>

{{ __('sales.currency') }}

</div>




<hr>





<h4 class="fw-bold">


{{ __('sales.total') }}

:

<span id="totalAmount" class="text-primary">
0.00
</span>

{{ __('sales.currency') }}


</h4>




</div>


</div>








<div class="text-end">


<a href="{{ route('sales.index') }}"
class="btn btn-outline-secondary px-4">

{{ __('sales.cancel') }}

</a>





<button type="submit"
class="btn btn-warning px-5">


<i class="bi bi-save me-1"></i>


{{ __('sales.update') }}


</button>



</div>






</form>


</div>


</div>


</div>



<script>


document.addEventListener('DOMContentLoaded',function(){



const invoiceDiscount =
document.getElementById('invoiceDiscount');


const beforeDiscount =
document.getElementById('beforeDiscount');


const itemsDiscount =
document.getElementById('itemsDiscount');


const invoiceDiscountAmount =
document.getElementById('invoiceDiscountAmount');


const totalAmount =
document.getElementById('totalAmount');





function money(value){

return Number(value || 0).toFixed(2);

}







function calculate(){



let total = 0;

let itemsDisc = 0;






document.querySelectorAll('#itemsBody tr')
.forEach(row=>{


let qty =
Number(
row.querySelector('.quantity').value
) || 0;



let price =
Number(
row.querySelector('.price').value
) || 0;




let discount =
Number(
row.querySelector('.discount').value
) || 0;






let subtotal =
qty * price;




let discountValue =
subtotal * discount / 100;





let final =
subtotal - discountValue;





row.querySelector('.subtotal').value =
money(final);





total += subtotal;


itemsDisc += discountValue;



});








let afterItems =
total - itemsDisc;





let invoiceDisc =
afterItems *
(Number(invoiceDiscount.value)||0)
/100;





let final =
afterItems - invoiceDisc;








beforeDiscount.innerText =
money(total);



itemsDiscount.innerText =
money(itemsDisc);



invoiceDiscountAmount.innerText =
money(invoiceDisc);



totalAmount.innerText =
money(final);



}








document.querySelectorAll('.quantity')
.forEach(input=>{


input.addEventListener('input',calculate);


});








document.querySelectorAll('.discount')
.forEach(input=>{


input.addEventListener('input',calculate);


});








invoiceDiscount.addEventListener('input',calculate);







calculate();



});



</script>


@endsection