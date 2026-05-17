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
        Schema::create('rapidshyp_serviceability_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->string('pickup_pincode', 6);
            $table->string('delivery_pincode', 6);
            $table->boolean('is_cod')->default(false);
            $table->decimal('total_order_value', 12, 2);
            $table->decimal('weight', 8, 3);
            $table->boolean('is_serviceable')->default(false);
            $table->json('courier_list')->nullable();
            $table->json('raw_response')->nullable();
            $table->string('api_status')->nullable();
            $table->text('error_message')->nullable();
            
            // Optional: link to order after creation
            $table->foreignId('order_id')->nullable()->constrained('rapidshyp_b2c_orders')->onDelete('set null');
            $table->string('selected_courier_code')->nullable();
            $table->string('selected_courier_name')->nullable();
            
            $table->timestamps();
            
            // Indexes for common queries
            $table->index('seller_id');
            $table->index('order_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapidshyp_serviceability_logs');
    }
};
