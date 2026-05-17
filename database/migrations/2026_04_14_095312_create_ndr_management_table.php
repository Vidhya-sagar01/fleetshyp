<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ndr_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_order_id')->unique(); // [cite: 31, 155]
            $table->string('waybill_number')->nullable()->index(); // [cite: 30, 156]
            
            // Fship Supported Actions [cite: 426]
            $table->enum('last_action_taken', ['re-attempt', 'change-address', 'change-phone', 'rto'])->nullable();
            
            // Re-attempt Fields 
            $table->dateTime('reattempt_date')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('mobilenumber')->nullable();
            $table->text('complete_address')->nullable();
            $table->text('remarks')->nullable();

            // API Logs
            $table->json('api_request_payload')->nullable();
            $table->json('api_response_data')->nullable();
            $table->string('status')->default('pending'); // pending, action_taken, resolved
            
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('ndr_management');
    }
};
