<?php

namespace App\Repositories;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use App\Interfaces\SaleRepositoryInterface;

class SaleRepository implements SaleRepositoryInterface
{
    /**
     * جلب جميع الفواتير بترتيب الأحدث مع العلاقات
     */
    public function all()
    {
        return Sale::with(['customer', 'items.product', 'payments'])
                    ->latest()
                    ->get();
    }

    /**
     * جلب فاتورة واحدة بالعلاقات
     */
    public function find($id)
    {
        $id = (int) $id; // ✅ تحويل آمن من string إلى int
        return Sale::with(['customer', 'items.product', 'payments'])
                    ->findOrFail($id);
    }

    /**
     * إنشاء فاتورة جديدة مع العناصر التابعة لها
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $total = collect($data['items'])->sum(
                fn($item) => $item['quantity'] * $item['price']
            );

            $sale = Sale::create([
                'customer_id'  => $data['customer_id'],
                'sale_date'    => $data['sale_date'],
                'total_amount' => $total,
                'status'       => $data['status'],
            ]);

            $sale->items()->createMany($data['items']);

            return $sale;
        });
    }

    /**
     * تحديث الفاتورة والعناصر التابعة لها
     */
    public function update($id, array $data)
    {
        $id = (int) $id; // ✅ تحويل آمن
        return DB::transaction(function () use ($id, $data) {
            $sale = $this->find($id);

            $total = collect($data['items'])->sum(
                fn($item) => $item['quantity'] * $item['price']
            );

            $sale->update([
                'customer_id'  => $data['customer_id'],
                'sale_date'    => $data['sale_date'],
                'total_amount' => $total,
                'status'       => $data['status'],
            ]);

            // تحديث العناصر
            $sale->items()->delete();
            $sale->items()->createMany($data['items']);

            return $sale;
        });
    }

    /**
     * حذف الفاتورة
     */
    public function delete($id)
    {
        $id = (int) $id; // ✅ تحويل آمن
        $sale = $this->find($id);
        return $sale->delete();
    }

    /**
     * إنشاء رقم فاتورة تلقائي (للاستخدام المستقبلي)
     */
    public function generateInvoiceNumber(): string
    {
        $lastId = Sale::max('id') + 1;
        return 'INV-' . str_pad($lastId, 5, '0', STR_PAD_LEFT);
    }
}
