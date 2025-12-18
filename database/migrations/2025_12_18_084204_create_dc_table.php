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
        Schema::create('delivery_challans', function (Blueprint $table) {
            $table->id();

            $table->string('ref')->nullable();
            $table->string('date')->nullable();
            $table->string('remarks')->nullable();
            $table->float('total')->nullable();
            $table->string('status')->nullable();
            

            $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dc');
    }
};
