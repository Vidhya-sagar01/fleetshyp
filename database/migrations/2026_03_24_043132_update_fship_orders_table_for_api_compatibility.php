<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fship_orders', function (Blueprint $table) {
            // 1. Payment Mode ko String se Integer mein badalna (1=COD, 2=Prepaid) 
            $table->integer('payment_mode')->comment('1=COD, 2=Prepaid')->change();

            // 2. Pickup Address ID ko Rename aur Type adjust karna 
            // Note: Iske liye 'composer require doctrine/dbal' zaroori ho sakta hai agar Laravel 9 se purana hai
            $table->renameColumn('pickup_address_id', 'pick_address_ID');

            // 3. Volumetric Weight ka column add karna jo PDF mein manga gaya hai [cite: 147, 168]
            $table->decimal('volumetric_weight', 8, 3)->nullable()->after('weight');

            // 4. Weight ko 500g limit ke liye properly define karna (Kgs mein) 
            $table->decimal('weight', 8, 3)->comment('Weight in Kgs (max 0.500 for 500g)')->change();

            // 5. Status ka default 'Booked' set karna [cite: 199]
            $table->string('status')->default('Booked')->change();
        });
    }

    public function down(): void
    {
        Schema::table('fship_orders', function (Blueprint $table) {
            $table->string('payment_mode')->change();
            $table->renameColumn('pick_address_ID', 'pickup_address_id');
            $table->dropColumn('volumetric_weight');
        });
    }
};