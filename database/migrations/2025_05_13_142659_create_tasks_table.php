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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('contractor_id')->nullable();
            $table->text('files')->nullable()->comment('JSON массив с информацией о файлах');
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('priority_id')->references('id')->on('task_priorities')->onDelete('set null');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('contractor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
