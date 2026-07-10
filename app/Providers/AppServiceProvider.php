<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Interfaces\CustomerRepositoryInterface;
use App\Repositories\CustomerRepository;
use App\Interfaces\PaymentRepositoryInterface;
use App\Repositories\PaymentRepository;
use App\Interfaces\SaleRepositoryInterface;        
use App\Repositories\SaleRepository;
use App\Interfaces\SupplierRepositoryInterface;      
use App\Repositories\SupplierRepository;
use App\Interfaces\PurchaseRepositoryInterface;   
use App\Repositories\PurchaseRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->bind(PurchaseRepositoryInterface::class, PurchaseRepository::class);
    }

    public function boot(): void
    {
        // إجبار النظام على استخدام الأرقام الإنجليزية في كل مكان
        setlocale(LC_ALL, 'en_US.UTF-8');
        \Carbon\Carbon::setLocale('ar'); // تترك التواريخ بالعربية لو رغبت

        // تحويل أي إخراج للأرقام العربية إلى إنجليزية
        \Illuminate\Support\Facades\Blade::directive('en_number', function ($expression) {
            return "<?php echo preg_replace('/[٠-٩]/u', function(\$match) { 
                return mb_ord(\$match[0]) - 1632; 
            }, $expression); ?>";
        });
    }
}
