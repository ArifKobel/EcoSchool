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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name der Kategorie (z.B. "Schulleitung und Steuerung")
            $table->string('slug')->unique(); // URL-friendly slug
            $table->text('description')->nullable(); // Beschreibung der Kategorie
            $table->integer('weight')->default(1); // Gewichtung für Berechnung
            $table->integer('question_count')->default(0); // Anzahl Fragen in dieser Kategorie
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
