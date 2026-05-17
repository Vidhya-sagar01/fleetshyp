<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     // database/migrations/xxxx_create_rapidshyp_b2c_order_items_table.php
public function up()
{
    Schema::create('rapidshyp_b2c_order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('rapidshyp_b2c_order_id')->constrained()->onDelete('cascade');
        $table->string('item_name', 200);
        $table->string('sku', 200)->nullable();
        $table->text('description')->nullable();
        $table->integer('units');
        $table->decimal('unit_price', 10, 2);
        $table->decimal('tax', 5, 2)->default(0);
        $table->string('hsn', 50)->nullable();
        $table->decimal('product_length', 8, 2)->nullable(); // cm
        $table->decimal('product_breadth', 8, 2)->nullable(); // cm
        $table->decimal('product_height', 8, 2)->nullable(); // cm
        $table->decimal('product_weight', 8, 2)->nullable(); // kg
        $table->string('brand', 100)->nullable();
        $table->string('image_url')->nullable();
        $table->boolean('is_fragile')->default(false);
        $table->boolean('is_personalisable')->default(false);
        $table->string('pickup_address_name')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapidshyp_b2c_order_items');
    }
};
