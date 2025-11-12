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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->char('ulid', 26)->primary(); // Primary Key
            
            // Foreign Key ke tabel products
            $table->char('product_id', 26);
            $table->foreign('product_id')->references('ulid')->on('products')->onDelete('restrict');
            
            $table->enum('movement_type', ['IN', 'OUT', 'ADJUST', 'TRANSFER']);
            $table->char('transaction_id', 26)->nullable(); // ID transaksi terkait (misal: purchase order, sales order, dll)

            $table->decimal('qty', 15, 2);
            $table->decimal('before_qty', 15, 2);
            $table->decimal('after_qty', 15, 2);
            
            $table->dateTime('movement_date')->useCurrent();
            $table->text('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};