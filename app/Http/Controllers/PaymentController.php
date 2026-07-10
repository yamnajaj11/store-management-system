<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentRepositoryInterface;
use Illuminate\Http\Request;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;


class PaymentController extends Controller
{
    protected $paymentRepo;

    public function __construct(PaymentRepositoryInterface $paymentRepo)
    {
        $this->paymentRepo = $paymentRepo;
    }

    // 🧾 عرض جميع الدفعات
    public function index()
    {
        $payments = $this->paymentRepo->getAll();
        return view('payments.index', compact('payments'));
    }

    // 👁️ عرض دفعة واحدة
    public function show($id)
    {
        $payment = $this->paymentRepo->getById($id);
        if (!$payment) {
            return redirect()->back()->withErrors('الدفعة غير موجودة');
        }
        return view('payments.show', compact('payment'));
    }

    // ➕ إنشاء دفعة جديدة
    public function create()
    {
        return view('payments.create');
    }

    // 💾 حفظ دفعة جديدة
    public function store(Request $request)
    {
        $data = $request->validate([
            'sale_id'      => 'required|exists:sales,id',
            'amount'       => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        $this->paymentRepo->create($data);
        return redirect()->route('payments.index')->with('success', 'تم إنشاء الدفعة بنجاح');
    }

    // ✏️ تعديل دفعة
    public function edit($id)
    {
        $payment = $this->paymentRepo->getById($id);
        if (!$payment) {
            return redirect()->back()->withErrors('الدفعة غير موجودة');
        }

        return view('payments.edit', compact('payment'));
    }

    // 🔁 تحديث دفعة
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'sale_id'      => 'required|exists:sales,id',
            'amount'       => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        $this->paymentRepo->update($id, $data);
        return redirect()->route('payments.index')->with('success', 'تم تعديل الدفعة بنجاح');
    }

    // 🗑️ حذف دفعة
    public function destroy($id)
    {
        $this->paymentRepo->delete($id);
        return redirect()->route('payments.index')->with('success', 'تم حذف الدفعة بنجاح');
    }


    // 📊 تصدير Excel
    public function exportExcel()
    {
        return Excel::download(new PaymentsExport, 'الدفعات.xlsx');
    }
}
