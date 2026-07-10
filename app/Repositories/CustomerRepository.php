<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * جلب جميع العملاء بدون ترقيم
     */
   public function getAll()
    {
        return Customer::withCount('sales')
                       ->withSum('sales', 'total_amount')
                       ->get();
    }
    /**
     * جلب عميل محدد بالمعرف
     */
    public function getById($id)
    {
        return Customer::find($id);
    }

    /**
     * إنشاء عميل جديد
     */
    public function create(array $data)
    {
        return Customer::create($data);
    }

    /**
     * تحديث بيانات عميل موجود
     */
    public function update($id, array $data)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->update($data);
            return $customer;
        }

        return null;
    }

    /**
     * حذف عميل من قاعدة البيانات
     */
    public function delete($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            return $customer->delete();
        }

        return false;
    }

    /**
     * إرجاع Query Builder مخصص لاستعلامات العملاء
     */
   public function query()
    {
        return Customer::withCount('sales')
                       ->withSum('sales', 'total_amount');
    }
}
