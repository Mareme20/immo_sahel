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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 15, 2);
            $table->string('location'); // ex: Almadies, Dakar
            $table->enum('type', ['sale', 'rent']); // Vente ou Location
            $table->enum('status', ['available', 'rented', 'maintenance'])->default('available');
            $table->integer('area')->nullable(); // en m2
            $table->integer('rooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->boolean('featured')->default(false); // Bien à la une
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
