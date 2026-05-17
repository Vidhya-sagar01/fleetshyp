=<?php

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
        Schema::create('rapidshyp_warehouses', function (Blueprint $table) {
            $table->id();

            // 🔗 Seller Relation (Multi-tenant support)
            // Note: Change 'users' to 'sellers' if you have a separate sellers table
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');

            // 📦 Pickup Address Fields (Mapped to RapidShyp API)
            $table->string('warehouse_name', 75)->comment('API: address_name (3-75 chars)');
            $table->string('contact_person', 150)->comment('API: contact_name (Only alphabets)');
            $table->string('contact_number', 15)->comment('API: contact_number (Starts 7,8,9 - 10 digits)');
            $table->string('email_id', 255)->comment('API: email');
            
            // 📍 Address Lines
            $table->string('address_line_1', 100)->comment('API: address_line (3-100 chars)');
            $table->string('address_line_2', 100)->nullable()->comment('API: address_line2 (3-100 chars if entered)');
            $table->char('pincode', 6)->comment('API: pincode (Exactly 6 digits)');

            // 🌍 Location Details (Auto-filled via Pincode API / Tracking Response)
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->default('INDIA');

            // 🏢 Business & Logistics
            $table->char('gstin', 15)->nullable()->comment('API: gstin (Valid 15-char GSTIN)');
            $table->decimal('latitude', 10, 8)->nullable()->comment('API: latitude (-90 to 90)');
            $table->decimal('longitude', 11, 8)->nullable()->comment('API: longitude (-180 to 180)');
            $table->string('warehousing_system', 20)->nullable()->comment('own/third_party');

            // 🔄 RTO & Routing Configuration
            $table->boolean('dropship_location')->default(false)->comment('API: dropship_location');
            $table->boolean('use_alt_rto_address')->default(false)->comment('API: use_alt_rto_address');
            $table->foreignId('rto_address_id')->nullable()
                ->constrained('rapidshyp_rto_addresses')
                ->nullOnDelete();

            // 🆔 RapidShyp API Response & System Flags
            $table->string('rapidshyp_warehouse_id', 50)->nullable()->comment('API response: pickup_location_name');
            $table->boolean('is_primary')->default(false);

            $table->timestamps();

            // 📊 Performance Indexes
            $table->index(['seller_id', 'is_primary'], 'idx_seller_primary');
            $table->index('pincode', 'idx_pincode');
            $table->index('rapidshyp_warehouse_id', 'idx_api_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapidshyp_warehouses');
    }
};