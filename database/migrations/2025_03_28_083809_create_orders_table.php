<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade'); // Client qui passe la commande
            $table->foreignId('service_id')->constrained()->onDelete('cascade'); // Service commandé
            $table->foreignId('professional_id')->constrained('users')->onDelete('cascade'); // Pro qui reçoit la commande
            $table->enum('status', ['pending', 'accepted', 'completed', 'canceled'])->default('pending'); // Statuts possibles
            $table->decimal('total_price', 10, 2);
            $table->string('city'); // Ville où se déroule le service
            $table->string('district'); // Quartier précis
            $table->dateTime('start_date'); // Date et heure de début du service
            $table->text('description')->nullable(); // Détails optionnels
            $table->text('notes')->nullable(); // Notes supplémentaires
            $table->timestamp('order_date')->useCurrent(); // Date de la commande
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};