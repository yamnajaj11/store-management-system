<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_number')
                ->unique();

            $table->foreignId('supplier_id')
                ->constrained()
                ->restrictOnDelete();

            $table->decimal('total_amount', 15, 2)
                ->default(0);

            $table->enum('status', [
                'مدفوع',
                'مدفوع جزئي',
                'غير مدفوع',
            ])->default('غير مدفوع');

            $table->timestamp('purchase_date')
                ->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
