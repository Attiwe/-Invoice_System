<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
             $table->string('invoice_number');
            $table->date('invoice_Date');
            $table->date('due_date')->nullable();  
            $table->string('product');
            $table->decimal('amount_collection', 8, 2)->nullable();  
            $table->decimal('amount_commission', 8, 2)->nullable();  
            $table->decimal('discoun', 8, 2); 
            $table->string('rate_vat',);  
            $table->decimal('value_vat', 8, 2)->nullable(); 
            $table->decimal('total', 8, 2)->nullable();  
            $table->string('status', 50);
            $table->integer('value_status');
            $table->text('note');
            $table->string('user');
            $table->date('pyment_data')->nullable();  
            $table->softDeletes(); 
            $table->timestamps();  
        });
    }
    
      
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
