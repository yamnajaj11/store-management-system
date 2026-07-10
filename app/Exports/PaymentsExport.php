<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Payment::select('id', 'sale_id', 'amount', 'payment_date')->get();
    }

    public function headings(): array
    {
        return ['رقم الدفعة', 'رقم الفاتورة', 'المبلغ', 'تاريخ الدفع'];
    }
}
