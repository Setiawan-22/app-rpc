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
        Schema::create('incoming_good_items', function (Blueprint $table) {
            $table->id(); // Auto-increment ID, bisa juga ULID/UUID
            
            // Foreign Key ke Header Transaksi
            $table->char('incoming_good_id', 26);
            $table->foreign('incoming_good_id')->references('ulid')->on('incoming_goods')->onDelete('cascade');
            
            // Foreign Key ke Master Produk
            $table->char('product_id', 26);
            $table->foreign('product_id')->references('ulid')->on('products')->onDelete('restrict');
            
            $table->Decimal('received_qty', 10, 2); // Jumlah barang yang diterima
            
            // Kita asumsikan UOM sudah ada di tabel products, jadi cukup dicatat (atau diambil dari products)
            // Jika UOM berbeda per penerimaan, Anda perlu FK ke tabel UOM atau mencatat string UOM di sini.
            
            $table->Decimal('price_per_unit', 15, 4)->nullable(); // Harga beli per unit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_good_items');
    }
};
