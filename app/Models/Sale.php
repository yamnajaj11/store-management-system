<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Sale extends Model
{

    protected $fillable = [

        'invoice_number',
        'customer_id',
        'total_amount',
        'discount',
        'final_amount',
        'status',
        'sale_date',

    ];



    protected $casts = [

        'total_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'sale_date' => 'datetime',

    ];




    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class)
            ->withDefault([
                'name' => 'عميل غير موجود'
            ]);
    }





    public function items(): HasMany
    {
        return $this->hasMany(
            SaleItem::class
        );
    }





    public function payments(): HasMany
    {
        return $this->hasMany(
            Payment::class
        );
    }





    /**
     * مجموع المبالغ المدفوعة
     */
    public function getPaidAmountAttribute(): float
    {

        return (float) 
            $this->payments()->sum('amount');

    }





    /**
     * المبلغ المتبقي
     */
    public function getRemainingAmountAttribute(): float
    {

        return max(
            0,
            (float) $this->final_amount -
            $this->paid_amount
        );

    }





    /**
     * الفاتورة مدفوعة بالكامل
     */
    public function getIsPaidAttribute(): bool
    {

        return $this->remaining_amount <= 0;

    }





    /**
     * الفاتورة دفع جزئي
     */
    public function getIsPartialPaidAttribute(): bool
    {

        return $this->paid_amount > 0
            &&
            $this->remaining_amount > 0;

    }


}