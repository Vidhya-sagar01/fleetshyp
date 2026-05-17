<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapidshyp_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  
            $table->enum('type', ['B2C', 'B2B']);
            $table->boolean('is_active')->default(true);
            $table->decimal('forward', 10, 2)->default(0);
            $table->decimal('rto', 10, 2)->default(0);
            $table->decimal('add_forward', 10, 2)->default(0);
            $table->decimal('add_rto', 10, 2)->default(0);
            $table->decimal('cod_charge', 10, 2)->default(0);
            $table->decimal('zcod_percent', 5, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->index(['user_id', 'type', 'is_active']);
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('rapidshyp_rate_cards');
    }
};

