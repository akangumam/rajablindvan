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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->date('expense_date'); // Tanggal pengeluaran
            $table->decimal('odometer', 12, 2)->nullable(); // Kilometer (opsional)
            $table->string('category'); // Kategori (Fuel, Maintenance, Insurance, Tax, Parking, dll)
            $table->string('subcategory')->nullable(); // Sub kategori
            $table->text('description'); // Deskripsi pengeluaran
            $table->decimal('amount', 10, 2); // Jumlah biaya
            $table->string('vendor')->nullable(); // Vendor/tempat pembayaran
            $table->string('payment_method')->nullable(); // Metode pembayaran
            $table->string('receipt_number')->nullable(); // Nomor kwitansi/nota
            $table->boolean('is_recurring')->default(false); // Pengeluaran berulang
            $table->string('recurring_period')->nullable(); // Periode berulang (monthly, yearly)
            $table->text('notes')->nullable(); // Catatan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
