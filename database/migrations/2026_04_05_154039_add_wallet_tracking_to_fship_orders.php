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
        Schema::table('fship_orders', function (Blueprint $table) {
            $table->decimal('wallet_deduction_amount', 10, 2)->default(0.00)->after('total_amount');
        
        // Register Pickup ke baad jo ID milti hai (Label ke liye zaroori) [cite: 820]
        $table->string('pickup_order_id')->nullable()->after('fship_api_order_id');
        
        // PDF ke hisab se split charges [cite: 966, 967, 968]
        $table->decimal('forward_charge', 10, 2)->default(0.00)->after('wallet_deduction_amount');
        $table->decimal('cod_charge', 10, 2)->default(0.00)->after('forward_charge');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fship_orders', function (Blueprint $table) {
            //
        });
    }
};
