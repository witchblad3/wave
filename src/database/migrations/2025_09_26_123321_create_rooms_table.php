<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id()->comment('Первичный ключ комнаты');

            $table->string('name')
                ->comment('Название комнаты/чата');

            $table->string('description')
                ->comment('Краткое описание комнаты');

            $table->boolean('is_private')
                ->default(false)
                ->comment('Приватная комната (true — вход по паролю)');

            $table->string('image')
                ->nullable()
                ->comment('Путь к обложке/аватару комнаты в Storage (например, public)');

            $table->foreignId('owner_id')
                ->constrained('users')
                ->cascadeOnDelete(); //('ID владельца комнаты (users.id)');

            $table->string('slug')
                ->unique()
                ->comment('Уникальный человекочитаемый идентификатор для URL');
            $table->string('image_disk', 16)
                ->default('public')
                ->comment('На каком диске сохранено');
            $table->string('password_hash')
                ->nullable()
                ->comment('Хеш пароля комнаты (bcrypt/argon). NULL, если комната публичная');

            $table->timestamps();

            $table->comment('Комнаты (чаты) приложения Wave');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
