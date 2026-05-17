<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('wallet_recharges', function (Blueprint $table) {
            // ✅ Add failure_reason column
            $table->text('failure_reason')->nullable()->after('status')
                  ->comment('Reason for payment failure');
        });
    }

    public function down()
    {
        Schema::table('wallet_recharges', function (Blueprint $table) {
            $table->dropColumn('failure_reason');
        });
    }
};