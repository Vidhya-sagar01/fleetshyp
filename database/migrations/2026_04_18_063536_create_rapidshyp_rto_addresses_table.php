<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates table: rapidshyp_rto_addresses
     * Purpose: Store RTO (Return to Origin) address details as per RapidShyp API
     */
    public function up(): void
    {
        Schema::create('rapidshyp_rto_addresses', function (Blueprint $table) {
            $table->id();

            // 🔗 Foreign Key: Seller/User who owns this RTO address
            $table->foreignId('seller_id')
                ->constrained('users')  // Change to 'sellers' if you have separate sellers table
                ->onDelete('cascade')
                ->comment('Foreign key to users/sellers table');

            // 📦 RTO Address Fields (Exact API Field Names from RapidShyp Documentation)
            
            // rto_address_name: API - Mandatory, min 1 char (but we enforce 3-75 for consistency)
            $table->string('rto_address_name', 75)
                ->comment('API: rto_address_name (3-75 chars)');

            // rto_contact_name: API - Mandatory, Only alphabets allowed
            $table->string('rto_contact_name', 100)
                ->comment('API: rto_contact_name (Only alphabets)');

            // rto_contact_number: API - Mandatory, Start 7,8,9 + exactly 10 digits
            $table->string('rto_contact_number', 15)
                ->comment('API: rto_contact_number (Cleaned 10-digit)');

            // rto_email: API - Optional, Valid email format
            $table->string('rto_email', 255)->nullable()
                ->comment('API: rto_email');

            // rto_address_line: API - Mandatory, 3-100 characters
            $table->string('rto_address_line', 100)
                ->comment('API: rto_address_line (3-100 chars)');

            // rto_address_line2: API - Optional, 3-100 characters if entered
            $table->string('rto_address_line2', 100)->nullable()
                ->comment('API: rto_address_line2 (3-100 chars if entered)');

            // rto_pincode: API - Mandatory, Exactly 6 digits
            $table->char('rto_pincode', 6)
                ->comment('API: rto_pincode (6 digits)');

            // 🌍 Location Details (Auto-filled via Pincode API)
            $table->string('rto_city', 100)->nullable()
                ->comment('Auto-filled from pincode API');
            
            $table->string('rto_state', 100)->nullable()
                ->comment('Auto-filled from pincode API');
            
            $table->string('rto_country', 100)->default('INDIA')
                ->comment('Default: INDIA');

            // 🏢 Business Details
            // rto_gstin: API - Optional, Valid 15-char GSTIN format
            $table->char('rto_gstin', 15)->nullable()
                ->comment('API: rto_gstin (Valid GSTIN: 24AAACO4716C1ZZ)');

            // 🔗 RapidShyp API Response ID (for tracking/sync)
            $table->string('rapidshyp_rto_id', 50)->nullable()
                ->comment('RapidShyp API response: rto_location_name');

            // ⏰ Timestamps
            $table->timestamps();

            // 📊 Performance Indexes
            $table->index(['seller_id', 'rto_pincode'], 'idx_seller_pincode');
            $table->index('rto_address_name', 'idx_rto_name');
            $table->index('rapidshyp_rto_id', 'idx_api_rto_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapidshyp_rto_addresses');
    }
};