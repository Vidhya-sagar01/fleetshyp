\<?php

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
        Schema::table('agreements', function (Blueprint $table) {
            // uploaded_by column ko nullable banayein
            $table->unsignedBigInteger('uploaded_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agreements', function (Blueprint $table) {
            // Wapas not null kar dein agar rollback kiya to
            $table->unsignedBigInteger('uploaded_by')->nullable(false)->change();
        });
    }
};