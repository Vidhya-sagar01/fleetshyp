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
        Schema::table('shipment_documents', function (Blueprint $table) {
            $table->string('courier_name')->nullable()->after('label_url');
            $table->string('pickup_status')->nullable()->default('MANIFESTED')->after('courier_name');
            $table->integer('shipment_count')->default(1)->after('pickup_status');
            $table->string('provider_pickup_id')->nullable()->after('shipment_count');
            $table->dateTime('pickup_date')->nullable()->after('provider_pickup_id');
            $table->timestamp('last_regenerated_at')->nullable()->after('remark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipment_documents', function (Blueprint $table) {
            //
        });
    }
};
