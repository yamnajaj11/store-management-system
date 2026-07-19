<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    protected $fillable = [
        'invoice_number',
        'supplier_id',
        'total_amount',
        'status',
        'purchase_date',
    ];

    protected $casts = [
        'purchase_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];


    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }


    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }


    public function payments(): HasMany
    {
        return $this->hasMany(PurchasePayment::class);
    }


    public function returns(): HasMany
    {
        return $this->hasMany(PurchaseReturn::class);
    }


    public function getPaidAmountAttribute()
    {
        return $this->payments->sum('amount');
    }


    public function getRemainingAmountAttribute()
    {
        $remaining = $this->net_amount - $this->paid_amount;

        return max($remaining, 0);
    }


    public function getCreditAmountAttribute()
    {
        $credit = $this->paid_amount - $this->net_amount;

        return max($credit, 0);
    }

    public function getReturnedAmountAttribute()
    {
        return $this->returns->sum('total_amount');
    }
    public function getNetAmountAttribute()
    {
        return $this->total_amount - $this->returned_amount;
    }
}