<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sale_orders', function (Blueprint $table) {
            
            $table->id();
            $table->timestamp('date')->nullable();
            $table->string('ref')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->nullable();
            $table->string('subtotal')->default(0)->nullable();
            $table->string('discount')->default(0)->nullable();
            $table->string('tax')->default(0)->nullable();
            $table->string('total')->default(0)->nullable();

            $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

            $table->string('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('sale_order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
            ->nullable()
            ->constrained('products')
            ->restrictOnDelete();

            $table->foreignId('sale_order_id')
            ->nullable()
            ->constrained('sale_orders')
            ->cascadeOnDelete();

            $table->string('price')->default(0)->nullable();
            $table->string('quantity')->default(0)->nullable();
            $table->string('discount')->default(0)->nullable();
            $table->string('tax')->default(0)->nullable();
            $table->string('total')->default(0)->nullable();

            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_order_items');
        Schema::dropIfExists('sale_orders');
    }
};
