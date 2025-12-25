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
        Schema::create('delivery_notes', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->nullable();
            $table->string('ref')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->nullable();
            $table->string('total')->default(0)->nullable();

            $table->foreignId('sale_order_id')
            ->nullable()
            ->constrained('sale_orders')
            ->nullOnDelete();

            $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

            $table->timestamps();
        });


        Schema::create('delivery_note_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
            ->nullable()
            ->constrained('products')
            ->restrictOnDelete();

            $table->foreignId('delivery_note_id')
            ->nullable()
            ->constrained('delivery_notes')
            ->cascadeOnDelete();

            $table->string('quantity')->default(0)->nullable();
            $table->string('price')->default(0)->nullable();
            $table->string('total')->default(0)->nullable();
            
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_note_items');
        Schema::dropIfExists('delivery_notes');
    }
};
