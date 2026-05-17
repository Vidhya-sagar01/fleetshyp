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
        Schema::create('shipping_labels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fship_order_id');
            $table->string('label_number')->unique(); 
            $table->string('barcode_path')->nullable(); 
            $table->enum('label_size', ['4x6', 'A4', 'A6'])->default('4x6');
            $table->enum('status', ['Generated', 'Printed', 'Cancelled'])->default('Generated');
            $table->timestamp('generated_at')->useCurrent();
            $table->unsignedBigInteger('generated_by');
            $table->foreign('fship_order_id')->references('id')->on('fship_orders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_labels');
    }
};
