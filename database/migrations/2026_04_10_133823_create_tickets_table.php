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
        Schema::create('tickets', function (Blueprint $table) {
             $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Logged in user
            $table->string('ticket_number')->unique(); // TKT-ABC123
            $table->string('category'); // First Mile, Last Mile, etc.
            $table->string('sub_category'); // Pickup Not Attempted, etc.
            $table->string('reference_id'); // AWB/Order IDs
            $table->text('remark')->nullable(); // Additional notes
            $table->json('attachments')->nullable(); // File paths array
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->text('admin_response')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            
            // Index for faster queries
            $table->index(['user_id', 'status']);
            $table->index('ticket_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};