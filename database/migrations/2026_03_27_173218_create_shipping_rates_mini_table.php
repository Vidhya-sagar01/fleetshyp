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
        Schema::create('shipping_rates_mini', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['mini','B2C', 'B2B'])->default('B2C');
            $table->string('plan_name')->nullable(); 
            
            // Courier Details
            $table->string('courier_name');
            $table->string('courier_logo')->nullable();
            $table->enum('mode', ['surface', 'air', 'express']);
            $table->string('mode_icon')->nullable();
            $table->string('weight_info')->nullable(); // e.g., "extra weight: 1 kg"
            
            // Zone A - Within City
            $table->decimal('zone_a_forward', 10, 2)->default(0);
            $table->decimal('zone_a_rto', 10, 2)->default(0);
            $table->decimal('zone_a_add_forward', 10, 2)->default(0);
            $table->decimal('zone_a_add_rto', 10, 2)->default(0);
            $table->decimal('zone_a_cod_charge', 10, 2)->default(0);
            $table->decimal('zone_a_cod_percent', 5, 2)->default(0);
            
            // Zone B - Within State
            $table->decimal('zone_b_forward', 10, 2)->default(0);
            $table->decimal('zone_b_rto', 10, 2)->default(0);
            $table->decimal('zone_b_add_forward', 10, 2)->default(0);
            $table->decimal('zone_b_add_rto', 10, 2)->default(0);
            $table->decimal('zone_b_cod_charge', 10, 2)->default(0);
            $table->decimal('zone_b_cod_percent', 5, 2)->default(0);
            
            // Zone C - Metro to Metro
            $table->decimal('zone_c_forward', 10, 2)->default(0);
            $table->decimal('zone_c_rto', 10, 2)->default(0);
            $table->decimal('zone_c_add_forward', 10, 2)->default(0);
            $table->decimal('zone_c_add_rto', 10, 2)->default(0);
            $table->decimal('zone_c_cod_charge', 10, 2)->default(0);
            $table->decimal('zone_c_cod_percent', 5, 2)->default(0);
            
            // Zone D - Rest of India
            $table->decimal('zone_d_forward', 10, 2)->default(0);
            $table->decimal('zone_d_rto', 10, 2)->default(0);
            $table->decimal('zone_d_add_forward', 10, 2)->default(0);
            $table->decimal('zone_d_add_rto', 10, 2)->default(0);
            $table->decimal('zone_d_cod_charge', 10, 2)->default(0);
            $table->decimal('zone_d_cod_percent', 5, 2)->default(0);
            
            // Zone E - Special Zones
            $table->decimal('zone_e_forward', 10, 2)->default(0);
            $table->decimal('zone_e_rto', 10, 2)->default(0);
            $table->decimal('zone_e_add_forward', 10, 2)->default(0);
            $table->decimal('zone_e_add_rto', 10, 2)->default(0);
            $table->decimal('zone_e_cod_charge', 10, 2)->default(0);
            $table->decimal('zone_e_cod_percent', 5, 2)->default(0);
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates_mini');
    }
};
