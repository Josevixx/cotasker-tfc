<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('team_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('task_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'review', 'paused', 'completed', 'cancelled'])
                  ->default('pending');
            $table->foreignId('task_list_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_lists');
        Schema::dropIfExists('team_user');
        Schema::dropIfExists('teams');
    }
};
