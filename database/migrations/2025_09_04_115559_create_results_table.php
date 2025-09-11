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
            $table->integer('total_points')->default(0);
            $table->integer('max_points')->default(100);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->enum('status', ['bronze', 'silver', 'gold']);
            $table->json('category_scores')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->boolean('is_final')->default(false);
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
