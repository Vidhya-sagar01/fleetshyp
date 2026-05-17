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
        Schema::table('shipping_labels', function (Blueprint $table) {
        $table->string('label_display_name')->nullable();
        $table->string('label_printer')->default('A4 Size');
        $table->string('label_template')->default('Standard A4');
        $table->boolean('show_signature_on_label')->default(false);
        $table->json('template_settings')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
