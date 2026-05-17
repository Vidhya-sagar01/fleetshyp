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
     Schema::create('fship_reverse_orders', function (Blueprint $table) {
       $table->id();
       $table->foreignId('forward_order_id')->constrained('fship_orders')->onDelete('cascade');
       $table->string('original_waybill')->index();
       $table->string('reverse_waybill')->nullable()->unique();
       $table->string('fship_api_order_id')->nullable();
       $table->boolean('is_qc_required')->default(false);
       $table->string('return_reason')->nullable();
       $table->integer('return_type')->default(0);
       $table->string('courier_name')->nullable();
       $table->string('route_code')->nullable();
       $table->string('status')->default('Initiated');
       $table->timestamp('reverse_order_created_at')->nullable();
       $table->timestamp('reverse_order_updated_at')->nullable();
       $table->timestamps();
     });
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
