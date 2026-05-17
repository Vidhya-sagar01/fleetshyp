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
            $table->decimal('shipping_charge', 10, 2)->default(0)->after('unit_price');
            $table->decimal('gift_wrap_charge', 10, 2)->default(0)->after('shipping_charge');
            $table->decimal('transaction_fee', 10, 2)->default(0)->after('gift_wrap_charge');
            $table->decimal('order_discount', 10, 2)->default(0)->after('transaction_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fship_order_items', function (Blueprint $table) {
            //
        });
    }
};
