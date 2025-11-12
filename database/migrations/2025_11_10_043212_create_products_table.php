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
        Schema::create('products', function (Blueprint $table) {
            $table->char('ulid', 26)->primary(); // Primary Key
            $table->char('product_id', 8)->unique();
            $table->string('kode_barang', 50)->unique();
            $table->string('nama_barang', 255);
            $table->text('deskripsi')->nullable();
            $table->string('uoms', 20); // Unit of Measure (Satuan)
            $table->decimal('price', 15, 2)->default(0);
            
            // Foreign Key ke tabel vendors
            $table->char('vendor_id', 26);
            $table->foreign('vendor_id')->references('ulid')->on('vendors')->onDelete('restrict');

            $table->timestamps(); // Menggantikan 'created_at' DATETIME
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};