<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('user_skills')) {
            Schema::create('user_skills', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
                $table->string('level')->default('Débutant');
                $table->timestamps();
                $table->unique(['user_id', 'skill_id']);
            });
            return;
        }

        Schema::table('user_skills', function (Blueprint $table) {
            if (!Schema::hasColumn('user_skills', 'user_id')) {
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            }

            if (!Schema::hasColumn('user_skills', 'skill_id')) {
                $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
            }

            if (!Schema::hasColumn('user_skills', 'level')) {
                $table->string('level')->default('Débutant');
            }

            if (!Schema::hasColumn('user_skills', 'created_at')) {
                $table->timestamps();
            }

            if (!Schema::hasIndex('user_skills', ['user_id', 'skill_id'])) {
                $table->unique(['user_id', 'skill_id']);
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_skills');
    }
};
