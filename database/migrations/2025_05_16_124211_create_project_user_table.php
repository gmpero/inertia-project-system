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
        Schema::create('project_user', function (Blueprint $table) {
            $table->id();

            // Беззнаковые целые числа для ID (оптимальнее для внешних ключей)
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id');

            // Метки времени создания/обновления
            $table->timestamps();

            // Внешние ключи с каскадным удалением
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade'); // Удаляем связь при удалении проекта
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Удаляем связь при удалении пользователя

            // Составной уникальный индекс
            $table->unique(['project_id', 'user_id']);

            // Отдельные индексы для часто используемых запросов
            $table->index('project_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_user');
    }
};
