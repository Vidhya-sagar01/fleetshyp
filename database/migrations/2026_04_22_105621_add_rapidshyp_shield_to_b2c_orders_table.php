<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up()
{
    Schema::table('rapidshyp_b2c_orders', function (Blueprint $table) {
        $table->boolean('rapidshyp_shield')->default(false)->after('collectable_value');
    });
}

public function down()
{
    Schema::table('rapidshyp_b2c_orders', function (Blueprint $table) {
        $table->dropColumn('rapidshyp_shield');
    });
}
};
