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
            $table->string('school_name')->nullable();
            $table->string('school_type')->nullable();
            $table->string('school_location')->nullable();
            $table->string('role')->nullable();
            $table->boolean('data_consent')->default(false);
            $table->timestamp('consent_given_at')->nullable();
            $table->boolean('anonymous_mode')->default(false);
            $table->json('preferences')->nullable();
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
