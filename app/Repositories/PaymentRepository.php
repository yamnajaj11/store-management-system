<?php

namespace App\Repositories;

use App\Interfaces\PaymentRepositoryInterface;
use App\Models\Payment;


class PaymentRepository implements PaymentRepositoryInterface
{


    public function getAll()
    {

        return Payment::with([
            'sale.customer'
        ])
        ->latest()
        ->get();

    }





    public function getById($id)
    {

        return Payment::with([
            'sale.customer'
        ])
        ->find($id);

    }





    public function create(array $data)
    {

        return Payment::create($data);

    }





    public function update($id, array $data)
    {

        $payment = Payment::find($id);


        if($payment){

            $payment->update($data);

            return $payment;

        }


        return null;

    }





    public function delete($id)
    {

        $payment = Payment::find($id);


        if($payment){

            return $payment->delete();

        }


        return false;

    }



}