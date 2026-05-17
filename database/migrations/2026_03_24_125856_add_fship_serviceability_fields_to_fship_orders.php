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
            $table->string('zone')->nullable()->after('state')->comment('Regional, Metro, etc.'); 
            $table->string('is_pickup_available', 5)->default('No')->after('zone');
            $table->string('is_delivery_available', 5)->default('No')->after('is_pickup_available');
            $table->string('is_cod_available', 5)->default('No')->after('is_delivery_available');
            $table->string('is_prepaid_available', 5)->default('No')->after('is_cod_available');
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
