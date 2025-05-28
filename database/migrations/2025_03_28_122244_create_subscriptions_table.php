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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pro qui souscrit
            $table->foreignId('pack_id')->constrained()->onDelete('cascade'); // Pack choisi
            $table->date('start_date'); // Date de début
            $table->date('end_date'); // Date de fin
            $table->enum('status', ['active', 'expired', 'canceled'])->default('active'); // Statut de l’abonnement
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
