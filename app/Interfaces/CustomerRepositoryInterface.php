<?php

namespace App\Interfaces;

interface CustomerRepositoryInterface
{
    /**
     * جلب جميع العملاء (بدون ترقيم)
     */
    public function getAll();

    /**
     * جلب عميل عبر المعرف (ID)
     */
    public function getById($id);

    /**
     * إنشاء عميل جديد
     */
    public function create(array $data);

    /**
     * تحديث بيانات عميل
     */
    public function update($id, array $data);

    /**
     * حذف عميل
     */
    public function delete($id);

    /**
     * إرجاع كائن Query لبناء استعلامات مخصصة (بحث، فلترة، ترتيب)
     */
    public function query();
}
