<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cod_remittance_payments', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('payment_mode');
            $table->string('bank_account')->nullable()->after('bank_name');
        });
    }

    public function down()
    {
        Schema::table('cod_remittance_payments', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'bank_account']);
        });
    }
};