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
        Schema::create('incoming_goods', function (Blueprint $table) {
            $table->char('ulid', 26)->primary(); // Primary Key ULID
            $table->string('reference_no', 50)->unique()->nullable(); // Nomor referensi penerimaan
            
            // Foreign Key ke Vendor
            $table->char('vendor_id', 26);
            $table->foreign('vendor_id')->references('ulid')->on('vendors')->onDelete('restrict');
            
            $table->dateTime('receipt_date');

            // --- FITUR BARU: TIPE PEMBAYARAN & JATUH TEMPO ---
            $table->enum('payment_type', ['CASH', 'TEMPO', 'COD']);
            $table->date('due_date')->nullable(); // Tanggal jatuh tempo, hanya diisi jika TEMPO
            // ------------------------------------------------

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_goods');
    }
};
