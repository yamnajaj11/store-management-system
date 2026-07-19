<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{

    /**
     * جميع العملاء
     */
    public function getAll()
    {
        return Customer::withCount('sales')
            ->withSum('sales', 'total_amount')
            ->get();
    }



    /**
     * عميل واحد مع مبيعاته ودفعاته
     */
    public function getById($id)
    {
        return Customer::with([
            'sales.payments'
        ])->find($id);
    }



    /**
     * إنشاء عميل
     */
    public function create(array $data)
    {
        $data['customer_number'] =
            $this->generateCustomerNumber();

        return Customer::create($data);
    }



    /**
     * تحديث عميل
     */
    public function update($id, array $data)
    {
        $customer = Customer::find($id);


        if (!$customer) {
            return null;
        }


        $customer->update($data);


        return $customer;
    }



    /**
     * حذف عميل
     */
    public function delete($id)
    {
        $customer = Customer::find($id);


        if (!$customer) {
            return false;
        }


        return $customer->delete();
    }



    /**
     * البحث والفلترة
     */
    public function query()
    {
        return Customer::withCount('sales')
            ->withSum('sales', 'total_amount');
    }



    /**
     * توليد رقم العميل
     */
    private function generateCustomerNumber(): string
    {
        $lastId = Customer::max('id') + 1;


        return 'CUS-' .
            str_pad(
                $lastId,
                6,
                '0',
                STR_PAD_LEFT
            );
    }

}