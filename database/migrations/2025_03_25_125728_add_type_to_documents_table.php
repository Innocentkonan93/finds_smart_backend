<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('type')->nullable()->after('file_path'); // Ajouter la colonne 'type'
            $table->boolean('is_validated')->default(false);
        });
    }

    /**
     * Rétrograder les migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('type'); // Supprimer la colonne 'type'
            $table->dropColumn('is_validated');
        });
    }
};
