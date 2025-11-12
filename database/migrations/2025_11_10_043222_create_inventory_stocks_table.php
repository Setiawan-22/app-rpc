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
        Schema::create('inventory_stocks', function (Blueprint $table) {
            $table->char('ulid', 26)->primary(); // Primary Key
            
            // Foreign Key ke tabel products
            $table->char('product_id', 26);
            $table->foreign('product_id')->references('ulid')->on('products')->onDelete('restrict');
            
            // Foreign Key ke tabel vendors (supplier/lokasi, tergantung interpretasi)
            // Saya asumsikan 'location_id' bisa jadi kode lokasi atau vendor_id yang menjadi lokasi stok
            // Berdasarkan relasi di ERD, ia terhubung ke vendors.
            $table->char('location_id', 25); // Jika ini bukan vendor_id, Anda mungkin perlu tabel 'locations' terpisah

            $table->decimal('current_qty', 15, 2)->default(0);
            $table->timestamp('last_update')->useCurrent(); // Menggunakan timestamp untuk 'last_update'

            // Tambahkan index unik untuk memastikan setiap produk di lokasi tertentu hanya punya 1 baris stok
            $table->unique(['product_id', 'location_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_stocks');
    }
};