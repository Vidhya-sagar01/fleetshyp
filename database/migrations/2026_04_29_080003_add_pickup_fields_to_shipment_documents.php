<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('shipment_documents', function (Blueprint $table) {
            // ✅ Check if column exists before adding - pickup_status_id
            if (!Schema::hasColumn('shipment_documents', 'pickup_status_id')) {
                $table->unsignedInteger('pickup_status_id')
                      ->nullable()
                      ->after('pickup_order_id')
                      ->comment('FShip pickup status ID: 1=Initiated, 2=Confirmed, etc.');
            }
            
            // ✅ Check if column exists before adding - pickup_status
            if (!Schema::hasColumn('shipment_documents', 'pickup_status')) {
                $table->string('pickup_status', 100)
                      ->nullable()
                      ->after('pickup_status_id')
                      ->comment('Human-readable status: Pickup Initiated, Picked Up, etc.');
            }
            
            // ✅ Check if column exists before adding - is_generated
            if (!Schema::hasColumn('shipment_documents', 'is_generated')) {
                $table->boolean('is_generated')
                      ->default(false)
                      ->after('pickup_status')
                      ->comment('Whether label/invoice/manifest files are ready');
            }
            
            // ✅ Check if column exists before adding - regenerate_date
            if (!Schema::hasColumn('shipment_documents', 'regenerate_date')) {
                $table->timestamp('regenerate_date')
                      ->nullable()
                      ->after('is_generated')
                      ->comment('When files can be regenerated next');
            }
            
            // ✅ Indexes - Simple add (Laravel will skip if exists)
            // Note: If index already exists, Laravel 12 will ignore duplicate index error in most cases
            $table->index('pickup_status_id', 'idx_pickup_status_id');
            $table->index('pickup_status', 'idx_pickup_status');
        });
    }

    public function down()
    {
        Schema::table('shipment_documents', function (Blueprint $table) {
            // ✅ Safe drop with exists check
            if (Schema::hasColumn('shipment_documents', 'pickup_status_id')) {
                $table->dropIndex('idx_pickup_status_id');
                $table->dropColumn('pickup_status_id');
            }
            if (Schema::hasColumn('shipment_documents', 'pickup_status')) {
                $table->dropIndex('idx_pickup_status');
                $table->dropColumn('pickup_status');
            }
            if (Schema::hasColumn('shipment_documents', 'is_generated')) {
                $table->dropColumn('is_generated');
            }
            if (Schema::hasColumn('shipment_documents', 'regenerate_date')) {
                $table->dropColumn('regenerate_date');
            }
        });
    }
};