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
        Schema::create('sale_invoice_items', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('product_id')
            ->nullable()
            ->constrained('users')
            ->restrictOnDelete();

            $table->foreignId('sale_invoice_id')
            ->nullable()
            ->constrained('sale_invoices')
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
        Schema::dropIfExists('sale_invoice_items');
    }

};
