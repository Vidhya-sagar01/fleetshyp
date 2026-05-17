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
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('section_name')->default('Seller Agreement');
            $table->string('version');
            $table->text('change_description')->nullable();
            $table->string('file_path'); 
            $table->string('file_name'); 
            $table->string('accepted_by')->nullable(); 
            $table->timestamp('acceptance_date')->nullable();
            $table->timestamp('published_at')->useCurrent();
            $table->string('ip_address')->nullable(); 
            $table->string('status')->default('pending'); 
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
            $table->index('version');
            $table->index('status');
            $table->index('section_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};