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
        Schema::create('packs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom du pack (ex: MAX, MINI, PRO)
            $table->decimal('price', 10, 2); // Prix en XOF
            $table->integer('duration'); // Durée en mois
            $table->boolean('highlight')->default(false); // Pour mettre en avant une offre
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packs');
    }
};
