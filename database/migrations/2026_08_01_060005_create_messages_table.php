<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
                $table->text('content');
                $table->timestamps();
            });
            return;
        }

        Schema::table('messages', function (Blueprint $table) {
            if (!Schema::hasColumn('messages', 'sender_id')) {
                $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            }

            if (!Schema::hasColumn('messages', 'receiver_id')) {
                $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            }

            if (!Schema::hasColumn('messages', 'content')) {
                $table->text('content');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
