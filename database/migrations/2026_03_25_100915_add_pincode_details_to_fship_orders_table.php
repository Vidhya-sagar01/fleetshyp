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
        Schema::table('fship_orders', function (Blueprint $table) {
            $table->string('source_pincode')->nullable()->after('pincode');
            $table->string('destination_pincode', 6)->nullable()->after('source_pincode');
            $table->string('source_destination')->nullable()->after('destination_pincode');
    });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fship_orders', function (Blueprint $table) {
            //
        });
    }
};
