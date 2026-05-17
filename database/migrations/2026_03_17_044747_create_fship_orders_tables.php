<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fship_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('fship_api_order_id')->nullable()->comment('apiorderid from fship'); 
            $table->string('waybill')->nullable()->index()->comment('Unique tracking number'); 
            $table->string('merchant_order_id')->unique()->comment('Internal Order ID from your form'); 
            $table->string('buyer_name'); 
            $table->string('phone_number'); 
            $table->string('email_id')->nullable(); 
            $table->text('complete_address'); 
            $table->string('pincode', 6); 
            $table->string('city'); 
            $table->string('state');
            $table->decimal('weight', 8, 3); 
            $table->decimal('length', 8, 2); 
            $table->decimal('width', 8, 2); 
            $table->decimal('height', 8, 2); 
            $table->integer('pickup_address_id'); 
            $table->string('payment_mode')->comment('1=COD, 2=Prepaid'); 
            $table->decimal('total_amount', 10, 2); 
            $table->string('courier_name')->nullable(); 
            $table->string('status')->default('Pending'); 
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fship_orders');
    }
};