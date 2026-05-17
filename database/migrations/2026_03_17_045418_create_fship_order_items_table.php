<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   
    public function up(): void {
        Schema::create('fship_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fship_order_id')->constrained()->onDelete('cascade');
            $table->string('product_name'); 
            $table->integer('quantity')->default(1); 
            $table->decimal('unit_price', 10, 2); 
            $table->string('sku')->nullable(); 
            $table->string('hsn_code')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fship_order_items');
    }
};