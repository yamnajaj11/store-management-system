<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Payment extends Model
{

    protected $fillable = [

        'sale_id',
        'amount',
        'method',
        'payment_date',
        'note',

    ];



    protected $casts = [

        'amount' => 'decimal:2',
        'payment_date' => 'datetime',

    ];



    public function sale(): BelongsTo
    {
        return $this->belongsTo(
            Sale::class
        );
    }

}