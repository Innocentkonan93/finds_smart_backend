<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image_path')->nullable(); // imagePath -> image_path
            $table->string('email_verification_code', 6)->nullable(); // emailVerificationCode -> email_verification_code
            $table->boolean('is_available')->default(true); // isAvailable -> is_available
            $table->boolean('is_active')->default(true); // isActive -> is_active
            $table->boolean('is_deleted')->default(false); // isDeleted -> is_deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image_path');
            $table->dropColumn('email_verification_code');
            $table->dropColumn('is_available');
            $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
        });
    }
}