<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->enum('preferred_contact', ['phone', 'whatsapp', 'email'])->default('phone');
            $table->date('preferred_visit_date')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->enum('status', ['new', 'qualified', 'visit_planned', 'converted', 'archived'])->default('new');
            $table->string('source')->default('website');
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_inquiries');
    }
};
