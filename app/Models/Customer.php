<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'customer_number',
        'name',
        'phone',
        'address',
        'opening_balance',
        'credit_limit',
        'is_active',
        'notes',
    ];


    protected $casts = [
        'opening_balance' => 'decimal:2',
        'credit_limit' => 'decimal:2',
        'is_active' => 'boolean',
    ];



    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */


    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }



    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */


    public function getTotalSalesAmountAttribute(): float
    {
        return $this->sales->sum('total_amount');
    }



    public function getBalanceAttribute(): float
    {
        return
            (float) $this->opening_balance
            +
            $this->sales->sum(
                fn($sale) => $sale->total_amount
            )
            -
            $this->sales
                ->flatMap(
                    fn($sale) => $sale->payments ?? []
                )
                ->sum('amount');
    }
}