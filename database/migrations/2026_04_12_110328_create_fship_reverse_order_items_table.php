<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fship_reverse_order_items', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('reverse_order_id')
                ->constrained('fship_reverse_orders')
                ->onDelete('cascade');
            
            // Product Details (Fship API fields)
            $table->string('product_name');           // productName *required
            $table->string('sku')->nullable();        // sku
            $table->integer('quantity');              // quantity *required
            $table->decimal('unit_price', 15, 2);     // unitPrice *required
            $table->decimal('total_price', 15, 2);    // calculated
            
            // Product Metadata (for QC)
            $table->string('product_category')->nullable();
            $table->string('hsn_code')->nullable();
            $table->string('brand_name')->nullable();    // *required if QC
            $table->string('color')->nullable();         // *required if QC
            $table->string('size')->nullable();          // *required if QC
            $table->string('ean_no')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('imei')->nullable();
            $table->boolean('is_fragile')->default(false);
            $table->string('image_url')->nullable();
            
            // Return Specific
            $table->string('return_reason')->nullable();
            $table->tinyInteger('return_type')->default(0); // 0=Return, 1=Exchange
            
            // QC Parameters (JSON as per Fship API)
            // Format: [{"questionId":"Take_Picture","question":"...","value":"Yes"}]
            $table->json('qc_parameters')->nullable();
            
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            
            $table->index(['reverse_order_id', 'sku']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fship_reverse_order_items');
    }
};