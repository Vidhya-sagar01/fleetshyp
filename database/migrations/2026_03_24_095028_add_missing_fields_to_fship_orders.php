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
            $table->string('alt_phone_number')->nullable()->after('phone_number');
            $table->string('landmark')->nullable()->after('complete_address');
            $table->string('order_type')->nullable()->after('merchant_order_id');
            $table->dateTime('order_date')->nullable()->after('order_type');
            $table->string('company_name')->nullable()->after('state');
            $table->string('gstin_number')->nullable()->after('company_name');
            $table->string('reseller_name')->nullable()->after('pick_address_ID');
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
