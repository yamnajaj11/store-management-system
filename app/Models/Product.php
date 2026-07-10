<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'purchase_price',
        'selling_price',
        'stock',
        'unit',
        'barcode',
        'supplier_id',
        'description',
    ];

    /**
     * ✅ تحويل القيم الرقمية (بدون تعديل عرض البيانات داخل الـ Model)
     * الأفضل استخدام casts بدل accessors
     */
    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price'  => 'decimal:2',
        'stock'          => 'integer',
    ];

    /**
     * ======================
     * العلاقات
     * ======================
     */

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}