<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class SaleItem extends Model
{

    protected $fillable = [

        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'discount',
        'subtotal',

    ];


    protected $casts = [

        'quantity' => 'integer',

        'unit_price' => 'decimal:2',

        'discount' => 'decimal:2',

        'subtotal' => 'decimal:2',

    ];



    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class)
            ->withDefault();
    }



    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)
            ->withDefault();
    }



    public function getOriginalTotalAttribute(): float
    {
        return (float)
            ($this->quantity * $this->unit_price);
    }



    public function getSubtotalAttribute($value): float
    {
        return (float) $value;
    }

}