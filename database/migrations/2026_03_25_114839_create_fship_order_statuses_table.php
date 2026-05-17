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
        Schema::create('fship_order_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fship_order_id')->constrained('fship_orders')->onDelete('cascade');
            $table->string('tag')->nullable();
            $table->string('status_code')->index(); 
            $table->string('status_name'); 
            $table->text('remarks')->nullable(); 
            $table->string('location')->nullable(); 
            $table->timestamp('status_date');
            $table->string('status');
            $table->text('note')->nullable();
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fship_order_statuses');
    }
};
