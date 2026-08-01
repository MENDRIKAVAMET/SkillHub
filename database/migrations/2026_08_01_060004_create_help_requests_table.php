<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('help_requests')) {
            Schema::create('help_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
                $table->text('message')->nullable();
                $table->string('status')->default('En attente');
                $table->timestamps();
            });
            return;
        }

        Schema::table('help_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('help_requests', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            }

            if (!Schema::hasColumn('help_requests', 'sender_id')) {
                $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            }

            if (!Schema::hasColumn('help_requests', 'receiver_id')) {
                $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            }

            if (!Schema::hasColumn('help_requests', 'skill_id')) {
                $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
            }

            if (!Schema::hasColumn('help_requests', 'message')) {
                $table->text('message')->nullable();
            }

            if (!Schema::hasColumn('help_requests', 'status')) {
                $table->string('status')->default('En attente');
            }

            // Drop the old user_id column if it exists and is no longer needed
            if (Schema::hasColumn('help_requests', 'user_id') && !Schema::hasColumn('help_requests', 'sender_id')) {
                // Only drop if we have sender_id (which we just added above)
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('help_requests');
    }
};
