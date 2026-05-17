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
     
    Schema::table('pickup_addresses', function (Blueprint $table) {
        // 1. Warehouse Name unique hona chahiye (Fship Identifier)
        $table->string('warehouse_name')->unique()->change();

        // 2. pick_address_ID ko index karein fast searching ke liye
        // Kyunki order creation mein isi ID ka use hoga
        $table->string('pick_address_ID')->nullable()->index()->change();

        // 3. Pincode validation ensure karne ke liye length set karein
        $table->string('pincode', 6)->change();
        
        // Agar SoftDeletes pehle se nahi hai toh add karein
        if (!Schema::hasColumn('pickup_addresses', 'deleted_at')) {
            $table->softDeletes();
        }
    });
}
       
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pickup_addresses', function (Blueprint $table) {
            //
        });
    }
};
