<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseItem extends Model
{

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'returned_quantity',
        'price',
        'subtotal',
    ];
    protected $casts = [
        'quantity' => 'integer',
        'returned_quantity' => 'integer',
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(
            PurchaseReturnItem::class,
            'purchase_item_id'
        );
    }

    public function getAvailableQuantityAttribute(): int
    {
        return $this->quantity - $this->returned_quantity;
    }
}