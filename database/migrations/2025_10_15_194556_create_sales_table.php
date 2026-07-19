<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {

            $table->id();

            // رقم الفاتورة
            $table->string('invoice_number')
                ->unique();

            $table->foreignId('customer_id')
                ->constrained()
                ->onDelete('restrict');

            $table->decimal(
                'total_amount',
                15,
                2
            );


            $table->decimal(
                'discount',
                5,
                2
            )->default(0);


            $table->decimal(
                'final_amount',
                15,
                2
            )->default(0);



            $table->enum('status', [
                'مدفوع',
                'مدفوع جزئي',
                'غير مدفوع'
            ])->default('غير مدفوع');


            $table->timestamp('sale_date')
                ->useCurrent();


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};