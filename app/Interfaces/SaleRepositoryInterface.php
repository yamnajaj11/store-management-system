<?php

namespace App\Interfaces;


interface SaleRepositoryInterface
{

    /**
     * جلب جميع فواتير العملاء
     */
    public function all();



    /**
     * جلب فاتورة واحدة
     */
    public function find(int $id);



    /**
     * إنشاء فاتورة
     */
    public function create(array $data);



    /**
     * تحديث فاتورة
     */
    public function update(
        int $id,
        array $data
    );



    /**
     * حذف فاتورة
     */
    public function delete(int $id);



    /**
     * توليد رقم فاتورة
     */
    public function generateInvoiceNumber(): string;

}