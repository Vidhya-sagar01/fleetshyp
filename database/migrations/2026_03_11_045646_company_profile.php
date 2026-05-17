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
        Schema::create('company_profiles', function (Blueprint $table) {
           $table->id();

        // seller/user id
        $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');

        // 4 digit unique company code
        $table->string('company_code',4)->unique();

        $table->string('company_name');
        $table->string('brand_name');
        $table->string('website')->nullable();

        $table->string('email');
        $table->string('customer_care_email')->nullable();
        $table->string('customer_care_mobile')->nullable();

        $table->boolean('has_gst')->default(false);
        $table->boolean('enable_state_gst')->default(false);

        $table->string('logo')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
