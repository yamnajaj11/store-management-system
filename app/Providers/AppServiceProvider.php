<?php

namespace App\Providers;

use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\InventoryRepositoryInterface;
use App\Interfaces\PaymentRepositoryInterface;
use App\Interfaces\PriceRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\PurchaseRepositoryInterface;
use App\Interfaces\SaleRepositoryInterface;
use App\Interfaces\SupplierRepositoryInterface;
use App\Repositories\CustomerRepository;
use App\Repositories\InventoryRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PriceRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SaleRepository;
use App\Repositories\SupplierRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\PurchaseReturnRepositoryInterface;
use App\Repositories\PurchaseReturnRepository;
use App\Interfaces\StockMovementRepositoryInterface;
use App\Repositories\StockMovementRepository;


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
        $this->app->bind(InventoryRepositoryInterface::class, InventoryRepository::class);
        $this->app->bind(PriceRepositoryInterface::class, PriceRepository::class);
        $this->app->bind(PurchaseReturnRepositoryInterface::class, PurchaseReturnRepository::class);
        $this->app->bind(StockMovementRepositoryInterface::class,StockMovementRepository::class
);
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
