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
        Schema::table('shipping_rates_mini', function (Blueprint $table) {

            // पहले new column add करो
            $table->unsignedBigInteger('courier_id')->nullable()->after('plan_name');

            // फिर old columns drop करो
            $table->dropColumn([
                'courier_name',
                'courier_logo',
                'courier_logo_url'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipping_rates_mini', function (Blueprint $table) {
            //
        });
    }
};
