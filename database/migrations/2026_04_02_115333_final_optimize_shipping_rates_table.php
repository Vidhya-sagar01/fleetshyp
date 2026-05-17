<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_rates_mini', function (Blueprint $table) {

            // 1. courier_id NOT NULL
            $table->unsignedBigInteger('courier_id')->nullable(false)->change();

            // 2. Indexes
            $table->index(['user_id', 'mode'], 'idx_user_mode');
            $table->index('courier_id', 'idx_courier');

            // 3. Unique Constraint
            $table->unique(['user_id', 'courier_id', 'mode'], 'unique_user_courier_mode');

            // 4. Foreign Key
            $table->foreign('courier_id', 'fk_shipping_courier')
                ->references('id')
                ->on('couriers')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('shipping_rates_mini', function (Blueprint $table) {

            // Drop FK
            $table->dropForeign('fk_shipping_courier');

            // Drop unique
            $table->dropUnique('unique_user_courier_mode');

            // Drop indexes
            $table->dropIndex('idx_user_mode');
            $table->dropIndex('idx_courier');

            // वापस nullable (rollback)
            $table->unsignedBigInteger('courier_id')->nullable()->change();
        });
    }
};
