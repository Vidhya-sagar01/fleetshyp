<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rapidshyp_warehouses', function (Blueprint $table) {
            if (!Schema::hasColumn('rapidshyp_warehouses', 'rto_location_name')) {
                $table->string('rto_location_name', 100)
                      ->nullable()
                      ->after('rapidshyp_warehouse_id')
                      ->comment('API response: rto_location_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rapidshyp_warehouses', function (Blueprint $table) {
            $table->dropColumn('rto_location_name');
        });
    }
};