<?php

namespace App\Interfaces;

interface SaleRepositoryInterface
{
    /**
     * إرجاع جميع الفواتير مع العلاقات
     */
    public function all();

    /**
     * إيجاد فاتورة محددة بواسطة المعرف
     */
    public function find(int $id);

    /**
     * إنشاء فاتورة جديدة
     */
    public function create(array $data);

    /**
     * تحديث فاتورة موجودة
     */
    public function update(int $id, array $data);

    /**
     * حذف فاتورة
     */
    public function delete(int $id);

    /**
     * توليد رقم فاتورة تلقائي (اختياري للتحسين المستقبلي)
     */
    public function generateInvoiceNumber(): string;
}
