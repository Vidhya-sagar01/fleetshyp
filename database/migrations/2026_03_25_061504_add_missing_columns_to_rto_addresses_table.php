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
        Schema::table('rto_addresses', function (Blueprint $table) {
            $table->string('pick_address_id')->nullable()->after('pickup_address_id');
            $table->string('warehouse_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rto_addresses', function (Blueprint $table) {
            //
        });
    }
};
