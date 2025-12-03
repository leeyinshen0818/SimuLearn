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
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('resource_file_path')->nullable()->after('scenario');
        });

        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_task_id')->constrained('user_tasks')->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->integer('attempt_number')->default(1);
            $table->enum('status', ['pending', 'graded'])->default('pending');
            $table->text('feedback')->nullable();
            $table->integer('score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('resource_file_path');
        });
    }
};
