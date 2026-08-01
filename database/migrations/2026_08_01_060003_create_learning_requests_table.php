<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('learning_requests')) {
            Schema::create('learning_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
                $table->text('message')->nullable();
                $table->string('status')->default('pending');
                $table->timestamps();
            });
            return;
        }

        Schema::table('learning_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('learning_requests', 'user_id')) {
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            }

            if (!Schema::hasColumn('learning_requests', 'skill_id')) {
                $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
            }

            if (!Schema::hasColumn('learning_requests', 'message')) {
                $table->text('message')->nullable();
            }

            if (!Schema::hasColumn('learning_requests', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_requests');
    }
};
