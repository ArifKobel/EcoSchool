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
        Schema::table('users', function (Blueprint $table) {
            $table->string('school_name')->nullable(); // Name der Schule (optional für Anonymität)
            $table->string('school_type')->nullable(); // Art der Schule (Grundschule, Gymnasium, etc.)
            $table->string('school_location')->nullable(); // Ort der Schule (optional)
            $table->string('role')->nullable(); // Rolle des Users (Lehrkraft, Schulleitung, etc.)
            $table->boolean('data_consent')->default(false); // DSGVO-Einwilligung
            $table->timestamp('consent_given_at')->nullable(); // Wann wurde die Einwilligung gegeben
            $table->boolean('anonymous_mode')->default(false); // Anonymer Modus aktiviert?
            $table->json('preferences')->nullable(); // Benutzerpräferenzen (JSON)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'school_name',
                'school_type',
                'school_location',
                'role',
                'data_consent',
                'consent_given_at',
                'anonymous_mode',
                'preferences'
            ]);
        });
    }
};
