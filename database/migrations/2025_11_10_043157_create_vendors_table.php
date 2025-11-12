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
        // Ada dua tabel 'vendors' di ERD, saya akan buat satu versi yang paling lengkap
        // dan saya tambahkan kolom foreign key 'contact_person' dan 'phone' dari versi lain.

        Schema::create('vendors', function (Blueprint $table) {
            $table->char('ulid', 26)->primary(); // Primary Key
            $table->string('vendor_code', 20)->unique();
            $table->string('vendor_name', 255);
            $table->text('address')->nullable();
            $table->string('contact_person', 100)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps(); // Menggantikan 'created_at' DATETIME
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};