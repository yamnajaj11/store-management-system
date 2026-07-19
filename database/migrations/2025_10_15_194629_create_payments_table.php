<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {

        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('sale_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal(
                'amount',
                15,
                2
            );

            $table->string('method')
                ->default('كاش');

            $table->timestamp('payment_date')
                ->useCurrent();

            $table->text('note')
                ->nullable();

            $table->timestamps();
        });

    }



    public function down(): void
    {
        Schema::dropIfExists('payments');
    }

};