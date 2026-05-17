<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cod_remittance_payments', function (Blueprint $table) {
            // ✅ Add waybill column after order_id
            $table->string('waybill')->nullable()->after('order_id')->comment('Waybill/AWB number for reference');
        });
    }

    public function down()
    {
        Schema::table('cod_remittance_payments', function (Blueprint $table) {
            $table->dropColumn('waybill');
        });
    }
};