<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agreement_acceptances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_id')->constrained('agreements')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users') ->cascadeOnDelete();
            $table->timestamp('accepted_at')->useCurrent();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            $table->unique(['agreement_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agreement_acceptances');
    }
};