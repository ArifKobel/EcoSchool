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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('total_points')->default(0); // Gesamtpunkte
            $table->integer('max_points')->default(100); // Maximale mögliche Punkte
            $table->decimal('percentage', 5, 2)->default(0); // Prozentuale Auswertung
            $table->enum('status', ['bronze', 'silver', 'gold']); // Status basierend auf Punkten
            $table->json('category_scores')->nullable(); // Punkte pro Kategorie
            $table->timestamp('completed_at')->nullable(); // Wann wurde der Fragebogen abgeschlossen
            $table->boolean('is_final')->default(false); // Ist dies das finale Ergebnis?
            $table->timestamps();

            $table->index(['user_id', 'is_final']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
