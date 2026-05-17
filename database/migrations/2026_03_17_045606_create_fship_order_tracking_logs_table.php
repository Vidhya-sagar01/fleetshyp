<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fship_order_tracking_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fship_order_id')->constrained()->onDelete('cascade');
            $table->string('status_text'); 
            $table->string('location')->nullable(); 
            $table->text('remarks')->nullable(); 
            $table->dateTime('scanned_at')->nullable(); 
            
            $table->timestamps();
        });
    }

  
    public function down(): void {
        Schema::dropIfExists('fship_order_tracking_logs');
    }
};