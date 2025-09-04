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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->text('question_text'); // Der eigentliche Fragetext
            $table->integer('order')->default(0); // Reihenfolge der Fragen
            $table->boolean('is_active')->default(true); // Aktiv/Inaktiv
            $table->integer('points')->default(1); // Punkte für Ja-Antwort
            $table->text('help_text')->nullable(); // Hilfstext für die Frage
            $table->json('metadata')->nullable(); // Zusätzliche Metadaten
            $table->timestamps();

            $table->index(['category_id', 'order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
