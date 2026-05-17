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
              if (!Schema::hasColumn('rto_addresses', 'pick_address_id')) {
                $table->string('pick_address_id')->nullable()->after('pickup_address_id');
            }

            // ✅ Missing address fields
            if (!Schema::hasColumn('rto_addresses', 'pincode')) {
                $table->string('pincode', 6)->nullable()->after('address_line1');
            }

            if (!Schema::hasColumn('rto_addresses', 'city')) {
                $table->string('city')->nullable()->after('pincode');
            }

            if (!Schema::hasColumn('rto_addresses', 'state_id')) {
                $table->unsignedBigInteger('state_id')->nullable()->after('city');
            }

            if (!Schema::hasColumn('rto_addresses', 'country_id')) {
                $table->unsignedBigInteger('country_id')->nullable()->after('state_id');
            }

            // ✅ warehouse name (already mentioned by you)
            if (!Schema::hasColumn('rto_addresses', 'warehouse_name')) {
                $table->string('warehouse_name')->nullable()->after('pick_address_id');
            }
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
