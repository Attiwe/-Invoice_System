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
        Schema::create('invoic_detals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_Invoice');
            $table->string('invoice_number', 50);
            $table->foreign('id_Invoice')->references('id')->on('invoices')->onDelete('cascade');
            $table->string('product', 50);
            $table->string('Section', 999);
            $table->string('status', 50);
            $table->integer(column: 'Value_Status');
            $table->date('Payment_Date')->nullable();
            $table->text('note')->nullable();
            $table->string('user',300);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoic_detals');
    }
};
