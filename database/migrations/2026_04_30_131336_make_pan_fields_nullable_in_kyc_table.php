<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kycs', function (Blueprint $table) {
            $table->string('pan_number')->nullable()->change();
            $table->string('pan_card_image')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('kycs', function (Blueprint $table) {
            $table->string('pan_number')->nullable(false)->change();
            $table->string('pan_card_image')->nullable(false)->change();
        });
    }
};
