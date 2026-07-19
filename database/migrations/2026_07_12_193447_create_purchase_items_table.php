<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('purchase_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('purchase_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('quantity');

            $table->integer('returned_quantity')
                ->default(0);

            // سعر الشراء
            $table->decimal('price', 15, 2);

            // مجموع السطر
            $table->decimal('subtotal', 15, 2)
                ->default(0);

            $table->timestamps();
        });
    }




    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }

};