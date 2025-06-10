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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Utilisateur qui poste l'annonce
            $table->foreignId('category_id')->constrained('job_categories')->onDelete('cascade'); // Catégorie du service
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->string('city');
            $table->string('district')->nullable(); // Quartier optionnel
            $table->enum('status', ['pending', 'accepted', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
