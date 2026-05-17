<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fship_orders', function (Blueprint $table) {
            // Add is_refunded if it doesn't exist
            if (!Schema::hasColumn('fship_orders', 'is_refunded')) {
                $table->boolean('is_refunded')->default(0)->after('has_reverse_order');
            }
            
            // Add remittance fields
            if (!Schema::hasColumn('fship_orders', 'is_remitted')) {
                $table->boolean('is_remitted')->default(0);
            }
            
            if (!Schema::hasColumn('fship_orders', 'remitted_at')) {
                $table->timestamp('remitted_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('fship_orders', function (Blueprint $table) {
            $table->dropColumn(['is_remitted', 'remitted_at']);
        });
    }
};