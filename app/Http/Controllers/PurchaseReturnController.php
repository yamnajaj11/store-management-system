<?php

namespace App\Http\Controllers;

use App\Interfaces\PurchaseReturnRepositoryInterface;
use App\Interfaces\PurchaseRepositoryInterface;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{

    public function __construct(
        protected PurchaseReturnRepositoryInterface $returnRepo,
        protected PurchaseRepositoryInterface $purchaseRepo
    ) {
    }





    public function index()
    {
        $returns = $this->returnRepo->all();


        return view(
            'purchase_returns.index',
            compact('returns')
        );
    }





    public function create($purchaseId)
    {

        $purchase = $this->purchaseRepo->find($purchaseId);


        return view(
            'purchase_returns.create',
            compact('purchase')
        );

    }






    public function store(Request $request)
    {

        $data = $request->validate([


            'purchase_id' =>
                'required|exists:purchases,id',


            'return_date' =>
                'required|date',


            'note' =>
                'nullable|string',



            'items' =>
                'required|array|min:1',



            'items.*.purchase_item_id' =>
                'required|exists:purchase_items,id',



            'items.*.quantity' =>
                'required|integer|min:1',


        ]);


        $this->returnRepo->create($data);



        return redirect()
            ->route('purchase_returns.index')
            ->with(
                'success',
                'تم إنشاء مرتجع الشراء بنجاح.'
            );

    }






    public function show($id)
    {

        $return = $this->returnRepo->find($id);



        return view(
            'purchase_returns.show',
            compact('return')
        );

    }

}