<?php

namespace App\Http\Controllers;


use App\Interfaces\StockMovementRepositoryInterface;



class StockMovementController extends Controller
{


    protected $movementRepo;



    public function __construct(
        StockMovementRepositoryInterface $movementRepo
    ) {

        $this->movementRepo = $movementRepo;

    }






    public function index()
    {
        $filters = request()->only([
            'date',
            'direction',
        ]);


        $movements =
            $this->movementRepo->getAll($filters);



        return view(
            'stock_movements.index',
            compact('movements')
        );
    }





    public function show($id)
    {


        $movement =
            $this->movementRepo->getById($id);



        if (!$movement) {

            return back()
                ->withErrors(
                    __('stock_movements.not_found')
                );

        }



        return view(
            'stock_movements.show',
            compact('movement')
        );


    }



}