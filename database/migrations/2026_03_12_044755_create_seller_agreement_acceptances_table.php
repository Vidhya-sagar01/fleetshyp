<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seller_agreement_acceptances', function (Blueprint $table) {

            $table->id();

            // Seller User ID
            $table->unsignedBigInteger('user_id');

            // Agreement Info
            $table->string('section_name')->default('Seller Agreement');
            $table->string('version')->default('1.0');
            $table->text('change_description')->nullable();

            // Acceptance Details
            $table->string('accepted_by')->nullable();
            $table->timestamp('acceptance_date')->nullable();

            // Agreement Publish Info
            $table->timestamp('published_on')->nullable();

            // Security / Audit
            $table->string('ip_address',45)->nullable();

            // Agreement document link
            $table->string('doc_link')->nullable();

            // Status
            $table->enum('status',['Accepted','Pending','Rejected'])->default('Accepted');

            $table->timestamps();

            // Foreign Key
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_agreement_acceptances');
    }
};
