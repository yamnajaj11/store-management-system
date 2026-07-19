<?php

namespace App\Http\Controllers;

use App\Interfaces\CustomerRepositoryInterface;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    protected $customerRepo;



    public function __construct(CustomerRepositoryInterface $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }



    /**
     * قائمة العملاء
     */
    public function index(Request $request)
    {

        $query = $this->customerRepo->query();



        if ($search = $request->get('search')) {

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('customer_number', 'like', "%{$search}%");

            });

        }



        if ($request->get('has_sales') == '1') {

            $query->whereHas('sales');

        }



        $customers = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();



        return view(
            'customers.index',
            compact('customers')
        );

    }





    /**
     * صفحة إضافة عميل
     */
    public function create()
    {
        return view('customers.create');
    }





    /**
     * حفظ العميل
     */
    public function store(Request $request)
    {

        $data = $request->validate([

            'name' => 'required|string|max:255',

            'phone' => 'nullable|string|max:20',

            'address' => 'nullable|string|max:255',

            'opening_balance' => 'nullable|numeric|min:0',

            'credit_limit' => 'nullable|numeric|min:0',

            'is_active' => 'nullable|boolean',

            'notes' => 'nullable|string',

        ]);



        $this->customerRepo->create($data);



        return redirect()
            ->route('customers.index')
            ->with(
                'success',
                __('messages.customer_created')
            );

    }





    /**
     * تفاصيل العميل
     */
    public function show($id)
    {

        $customer = $this->customerRepo->getById($id);



        if (!$customer) {

            return redirect()
                ->route('customers.index')
                ->withErrors(
                    __('messages.customer_not_found')
                );

        }



        return view(
            'customers.show',
            compact('customer')
        );

    }





    /**
     * صفحة تعديل
     */
    public function edit($id)
    {

        $customer = $this->customerRepo->getById($id);



        if (!$customer) {

            return redirect()
                ->route('customers.index')
                ->withErrors(
                    __('messages.customer_not_found')
                );

        }



        return view(
            'customers.edit',
            compact('customer')
        );

    }





    /**
     * تحديث العميل
     */
    public function update(Request $request, $id)
    {

        $data = $request->validate([

            'name' => 'required|string|max:255',

            'phone' => 'nullable|string|max:20',

            'address' => 'nullable|string|max:255',

            'opening_balance' => 'nullable|numeric|min:0',

            'credit_limit' => 'nullable|numeric|min:0',

            'is_active' => 'nullable|boolean',

            'notes' => 'nullable|string',

        ]);



        $this->customerRepo->update(
            $id,
            $data
        );



        return redirect()
            ->route('customers.index')
            ->with(
                'success',
                __('messages.customer_updated')
            );

    }





    /**
     * حذف العميل
     */
    public function destroy($id)
    {

        $this->customerRepo->delete($id);



        return redirect()
            ->route('customers.index')
            ->with(
                'success',
                __('messages.customer_deleted')
            );

    }

}