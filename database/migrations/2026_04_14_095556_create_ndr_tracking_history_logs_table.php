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
      Schema::create('ndr_tracking_history_logs', function (Blueprint $table) {
            $table->id();
            $table->string('waybill_number')->index(); 
            $table->dateTime('scan_date_time'); 
            $table->string('scan_status'); 
            $table->string('scan_location')->nullable(); 
            $table->text('scan_remark')->nullable();
            $table->integer('shipment_journey')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ndr_tracking_history_logs');
    }
};
