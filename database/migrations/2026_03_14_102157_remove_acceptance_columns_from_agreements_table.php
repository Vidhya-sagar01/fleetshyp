<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agreements', function (Blueprint $table) {

            // Remove seller acceptance fields
            $table->dropColumn([
                'accepted_by_file_path',
                'accepted_by_file_name',
                'accepted_by',
                'accepted_by_ip',
                'acceptance_date',
                'ip_address',
            ]);

        });
    }

    public function down(): void
    {
        Schema::table('agreements', function (Blueprint $table) {

            // Restore columns if rollback
            $table->string('accepted_by_file_path')->nullable();
            $table->string('accepted_by_file_name')->nullable();
            $table->string('accepted_by')->nullable();
            $table->string('accepted_by_ip')->nullable();
            $table->timestamp('acceptance_date')->nullable();
            $table->string('ip_address')->nullable();

        });
    }
};