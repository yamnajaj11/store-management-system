<?php

namespace App\Http\Controllers;

use App\Interfaces\SaleRepositoryInterface;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class SaleController extends Controller
{
    protected SaleRepositoryInterface $saleRepo;

    public function __construct(SaleRepositoryInterface $saleRepo)
    {
        $this->saleRepo = $saleRepo;
    }

    /** عرض جميع الفواتير */
    public function index()
    {
        $sales = $this->saleRepo->all();
        return view('sales.index', compact('sales'));
    }

    /** صفحة إنشاء فاتورة جديدة */
    public function create()
    {
        return view('sales.create');
    }

    /** حفظ الفاتورة */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'        => 'required|exists:customers,id',
            'sale_date'          => 'required|date',
            'status'             => 'required|in:مدفوع,مدفوع جزئي,غير مدفوع',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.price'      => 'required|numeric|min:0',
        ]);

        $this->saleRepo->create($validated);

        return redirect()->route('sales.index')->with('success', 'تم إنشاء الفاتورة بنجاح.');
    }

    /** عرض فاتورة محددة */
    public function show($id)
    {
        $sale = $this->saleRepo->find($id);
        return view('sales.show', compact('sale'));
    }

    /** تعديل الفاتورة */
    public function edit($id)
    {
        $sale = $this->saleRepo->find($id);
        return view('sales.edit', compact('sale'));
    }

    /** تحديث الفاتورة */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id'        => 'required|exists:customers,id',
            'sale_date'          => 'required|date',
            'status'             => 'required|in:مدفوع,مدفوع جزئي,غير مدفوع',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.price'      => 'required|numeric|min:0',
        ]);

        $this->saleRepo->update($id, $validated);

        return redirect()->route('sales.index')->with('success', 'تم تحديث الفاتورة بنجاح.');
    }

    /** حذف الفاتورة */
    public function destroy($id)
    {
        $this->saleRepo->delete($id);
        return redirect()->route('sales.index')->with('success', 'تم حذف الفاتورة.');
    }

    /** تصدير إلى Excel */
    public function exportExcel()
    {
        return Excel::download(new SalesExport, 'الفواتير.xlsx');
    }



 
}
