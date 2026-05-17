<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cod_remittance_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');          
            $table->unsignedBigInteger('order_id');         
            $table->unsignedBigInteger('admin_id')->nullable(); 
            $table->decimal('remitted_amount', 15, 2);      
            $table->string('payment_reference')->nullable();
            $table->decimal('convenience_fee', 10, 2)->default(0);
            $table->date('payment_date');                 
            $table->string('payment_mode')->nullable();     
            $table->enum('status', ['pending', 'processed', 'paid', 'cancelled'])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('order_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cod_remittance_payments');
    }
};