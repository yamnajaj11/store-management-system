<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{

    protected $fillable = [

        'supplier_number',

        'name',

        'company',

        'phone',

        'address',

        'opening_balance',

        'note',

    ];



    protected $casts = [

        'opening_balance' => 'decimal:2',

    ];





    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }





    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'supplier_products'
        );
    }





    /*
    |--------------------------------------------------------------------------
    | الرصيد الحالي للمورد
    |--------------------------------------------------------------------------
    */

    public function getBalanceAttribute()
    {


        // مجموع المشتريات
        $purchases = $this->purchases
            ->sum('total_amount');



        // مجموع الدفعات
        $payments = $this->purchases
            ->flatMap(function ($purchase) {

                return $purchase->payments;

            })
            ->sum('amount');



        // مجموع المرتجعات
        $returns = $this->purchases
            ->flatMap(function ($purchase) {

                return $purchase->returns;

            })
            ->sum('total_amount');




        return

            $this->opening_balance

            +

            $purchases

            -

            $payments

            -

            $returns;

    }

}