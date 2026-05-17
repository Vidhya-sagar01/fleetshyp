<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_labels', function (Blueprint $table) {
            // ✅ Make fship_order_id nullable for user settings
            $table->bigInteger('fship_order_id')->unsigned()->nullable()->change();
            
            // ✅ Also make generated_by nullable (if not already)
            $table->bigInteger('generated_by')->unsigned()->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('shipping_labels', function (Blueprint $table) {
            // Revert (be careful - ensure no NULL values exist first)
            $table->bigInteger('fship_order_id')->unsigned()->nullable(false)->change();
            $table->bigInteger('generated_by')->unsigned()->nullable(false)->change();
        });
    }
};