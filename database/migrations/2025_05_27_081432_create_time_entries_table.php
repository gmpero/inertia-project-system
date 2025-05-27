<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('time_entries', function (Blueprint $table) {
            // Основные колонки
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('minutes')->unsigned();
            $table->text('comment')->nullable();
            $table->timestamps();

            // Индексы
            $table->index('task_id');
            $table->index('user_id');
        });

        // Отдельные операции для внешних ключей
        Schema::table('time_entries', function (Blueprint $table) {
            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_entries');
    }
};
