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

       Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->string('ref')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->nullable();
            $table->string('is_paid')->nullable();
            
            $table->string('subtotal')->default(0)->nullable();
            $table->string('tax')->default(0)->nullable();
            $table->string('discount')->default(0)->nullable();
            $table->string('total')->default(0)->nullable();

            $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

            $table->timestamps();
        });


        Schema::create('sale_invoice_items', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('delivery_note_id')
            ->nullable()
            ->constrained('delivery_notes')
            ->restrictOnDelete();

            $table->foreignId('sale_invoice_id')
            ->nullable()
            ->constrained('sale_invoices')
            ->cascadeOnDelete();
            
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
        Schema::dropIfExists('sale_invoices');
    }

};
