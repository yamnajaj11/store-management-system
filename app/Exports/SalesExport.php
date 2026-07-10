<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    /**
     * جلب بيانات المبيعات من قاعدة البيانات
     */
    public function collection()
    {
        return Sale::select('id', 'customer_id', 'total_amount', 'sale_date')->get();
    }

    /**
     * عناوين الأعمدة في ملف الإكسل
     */
    public function headings(): array
    {
        return ['رقم الفاتورة', 'رقم العميل', 'المبلغ الإجمالي', 'تاريخ البيع'];
    }
}
