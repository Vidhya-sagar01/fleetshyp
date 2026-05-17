<?php

// database/migrations/xxxx_xx_xx_xxxxxx_increase_serviceability_columns_length_in_fship_orders.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fship_orders', function (Blueprint $table) {
            // Agar columns ENUM hain toh pehle drop karein, fir VARCHAR banayein
            $table->string('zone', 50)->change();                    // 'Pending', 'Zone-A', etc.
            $table->string('is_pickup_available', 20)->change();     // 'Pending', 'Yes', 'No'
            $table->string('is_delivery_available', 20)->change();   // 'Pending', 'Yes', 'No'
            $table->string('is_cod_available', 10)->change();        // 'Yes', 'No', 'NA'
            $table->string('is_prepaid_available', 10)->change();    // 'Yes', 'No', 'NA'
        });
    }

    public function down()
    {
        Schema::table('fship_orders', function (Blueprint $table) {
            $table->string('zone', 20)->change();
            $table->enum('is_pickup_available', ['Yes', 'No'])->change();
            $table->enum('is_delivery_available', ['Yes', 'No'])->change();
            $table->enum('is_cod_available', ['Yes', 'No'])->change();
            $table->enum('is_prepaid_available', ['Yes', 'No'])->change();
        });
    }
};
