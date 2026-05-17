<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapidshyp_b2c_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');

            // Order Details
            $table->string('order_id')->unique();
            $table->date('order_date');
            $table->string('store_name')->default('DEFAULT');

            // Pickup
            $table->string('pickup_address_name')->nullable();
            $table->json('pickup_location')->nullable(); // if created inline

            // Addresses
            $table->json('shipping_address');
            $table->boolean('billing_is_shipping')->default(true);
            $table->json('billing_address')->nullable();

            // Products
            $table->json('order_items');

            // Package
            $table->json('package_details');

            // Payment
            $table->enum('payment_method', ['COD', 'PREPAID'])->default('COD');
            $table->decimal('shipping_charges', 10, 2)->default(0);
            $table->decimal('gift_wrap_charges', 10, 2)->default(0);
            $table->decimal('transaction_charges', 10, 2)->default(0);
            $table->decimal('total_discount', 10, 2)->default(0);
            $table->decimal('total_order_value', 10, 2)->default(0);
            $table->decimal('cod_charges', 10, 2)->default(0);
            $table->decimal('prepaid_amount', 10, 2)->default(0);
            $table->decimal('collectable_value', 10, 2)->default(0);

            // API Response
            $table->json('api_response')->nullable();
            $table->string('api_status')->nullable(); // success / error
            $table->string('awb')->nullable();
            $table->string('shipment_id')->nullable();

            // Order Status
            $table->string('order_status')->default('PENDING');
            // PENDING, PROCESSING, READY_TO_SHIP, SHIPPED, DELIVERED, CANCELLED, RTO

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['seller_id', 'order_status']);
            $table->index('awb');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapidshyp_b2c_orders');
    }
};