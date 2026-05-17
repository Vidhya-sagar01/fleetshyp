<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_labels', function (Blueprint $table) {
            // ✅ Make 'label_number' nullable
            $table->string('label_number')->nullable()->change();
            
            // ✅ Make 'fship_order_id' nullable (for settings record)
            $table->unsignedBigInteger('fship_order_id')->nullable()->change();
            
            // ✅ Make 'generated_by' nullable (for settings record)
            $table->unsignedBigInteger('generated_by')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('shipping_labels', function (Blueprint $table) {
            $table->string('label_number')->nullable(false)->change();
            $table->unsignedBigInteger('fship_order_id')->nullable(false)->change();
            $table->unsignedBigInteger('generated_by')->nullable(false)->change();
        });
    }
};