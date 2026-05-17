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
        Schema::table('fship_order_items', function (Blueprint $table) {
            $table->string('brand_name')->nullable()->after('sku');
            $table->text('product_image_url')->nullable()->after('brand_name');
            $table->json('qc_json')->nullable()->after('product_image_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fship_order_items', function (Blueprint $table) {
            $table->dropColumn(['brand_name', 'product_image_url', 'qc_json']);
        });
    }
};