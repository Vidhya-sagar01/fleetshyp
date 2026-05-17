<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('couriers', function (Blueprint $table) {
            // Fship API का Actual Courier ID (59, 60, 64, 65, 88, etc.)
            $table->unsignedBigInteger('fship_courier_id')
                  ->nullable()
                  ->after('id')
                  ->comment('Fship API Actual Courier ID');
            
            // Filtering के लिए Index add करें (Performance improve होगी)
            $table->index('fship_courier_id', 'idx_fship_courier_id');
        });
    }

    public function down()
    {
        Schema::table('couriers', function (Blueprint $table) {
            $table->dropIndex('idx_fship_courier_id');
            $table->dropColumn('fship_courier_id');
        });
    }
};