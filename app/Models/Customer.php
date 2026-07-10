<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'address'];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    // 🔹 مجموع إجمالي المبيعات
    public function getTotalSalesAmountAttribute(): float
    {
        return $this->sales->sum('total_amount');
    }
}
