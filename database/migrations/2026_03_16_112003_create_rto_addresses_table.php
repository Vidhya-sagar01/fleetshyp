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
        Schema::create('rto_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pickup_address_id')->constrained('pickup_addresses')->cascadeOnDelete();
            $table->string('rto_nick_name');
            $table->string('contact_name');
            $table->string('phone', 15);
            $table->string('email');
            $table->text('address_line1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rto_addresses');
    }
};
