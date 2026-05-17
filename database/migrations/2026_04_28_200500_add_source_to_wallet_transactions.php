// database/migrations/xxxx_xx_xx_add_source_to_wallet_transactions.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->string('source', 50)
                  ->nullable()
                  ->default('admin_manual')
                  ->after('charge_type')
                  ->comment('Source: admin_manual, razorpay, fship_booking, etc.');
            $table->index('source');
        });
    }

    public function down()
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropIndex(['source']);
            $table->dropColumn('source');
        });
    }
};