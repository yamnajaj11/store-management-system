<?php

namespace App\Repositories;


use App\Interfaces\StockMovementRepositoryInterface;
use App\Models\StockMovement;


class StockMovementRepository implements StockMovementRepositoryInterface
{


    public function getAll($filters = [])
    {

        $query = StockMovement::with([
            'product',
            'reference'
        ]);



        // فلترة حسب اليوم
        if (!empty($filters['date'])) {

            $query->whereDate(
                'created_at',
                $filters['date']
            );

        }




        // دخول / خروج
        if (!empty($filters['direction'])) {


            if ($filters['direction'] == 'in') {


                $query->where(
                    'quantity',
                    '>',
                    0
                );


            }


            if ($filters['direction'] == 'out') {


                $query->where(
                    'quantity',
                    '<',
                    0
                );


            }


        }



        return $query
            ->latest()
            ->get();

    }





    public function getById($id)
    {

        return StockMovement::with([
            'product',
            'reference'
        ])
            ->find($id);

    }


}