<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fship_orders', function (Blueprint $table) {
            $table->timestamp('expected_delivery_date')->nullable()
                  ->comment('ETA shown to user at booking time (from Fship API)')
                  ->after('booked_at');
        });
    }

    public function down()
    {
        Schema::table('fship_orders', function (Blueprint $table) {
            $table->dropColumn('expected_delivery_date');
        });
    }
};