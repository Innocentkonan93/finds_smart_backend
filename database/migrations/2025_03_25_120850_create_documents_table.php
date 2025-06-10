<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');  // Stocke le chemin du fichier
            $table->string('original_name');  // Stocke le nom original du fichier
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Associe le document à un utilisateur
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
}