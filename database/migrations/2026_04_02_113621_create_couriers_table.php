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
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('logo')->nullable();
            $table->longText('logo_url')->nullable();

            $table->decimal('rating_pickup', 2,1)->default(0);
            $table->decimal('rating_delivery', 2,1)->default(0);
            $table->decimal('rating_ndr', 2,1)->default(0);
            $table->decimal('rating_weight', 2,1)->default(0);
            $table->decimal('rating_tat', 2,1)->default(0);

            $table->string('expected_pickup')->nullable();
            $table->string('estimated_delivery')->nullable();

            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
