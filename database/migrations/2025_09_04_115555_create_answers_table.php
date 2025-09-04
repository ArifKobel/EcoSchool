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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->boolean('answer'); // true = Ja, false = Nein
            $table->integer('points_awarded')->default(0); // Vergebene Punkte
            $table->timestamp('answered_at'); // Wann wurde geantwortet
            $table->timestamps();

            $table->unique(['user_id', 'question_id']); // Ein User kann eine Frage nur einmal beantworten
            $table->index(['user_id', 'answered_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
