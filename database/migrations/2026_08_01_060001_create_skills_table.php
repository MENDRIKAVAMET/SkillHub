<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('skills')) {
            Schema::create('skills', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
            });
            return;
        }

        Schema::table('skills', function (Blueprint $table) {
            if (!Schema::hasColumn('skills', 'name')) {
                $table->string('name')->unique();
            }

            if (!Schema::hasColumn('skills', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            if (Schema::hasColumn('skills', 'name')) {
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('skills', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
