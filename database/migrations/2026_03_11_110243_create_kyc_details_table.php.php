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
        Schema::create('kyc_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('verification_method')->default('Express KYC');
            $table->enum('status', ['PENDING', 'VERIFIED', 'REJECTED'])->default('PENDING'); 
            $table->string('business_type')->default('Individual');
            $table->string('pan_number');
            $table->string('aadhaar_number');
            $table->string('user_photo')->nullable(); 
            $table->string('pan_card_image')->nullable();
            $table->string('aadhaar_card_image')->nullable(); // Aadhaar ki copy
            $table->timestamp('verified_at')->nullable();
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
