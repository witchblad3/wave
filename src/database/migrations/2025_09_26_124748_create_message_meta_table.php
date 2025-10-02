<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_metas', function (Blueprint $table) {
            $table->id()->comment('Первичный ключ записи метаданных');

            $table->foreignId('message_id')
                ->constrained('messages')
                ->cascadeOnDelete(); //('ID сообщения (messages.id), к которому относится мета-запись');

            $table->string('meta_key', 64)
                ->comment('Ключ метаданных (например: duration, file_path, codec, user_id)');

            $table->string('meta_value', 255)
                ->nullable()
                ->comment('Значение метаданных в строковом виде; NULL, если ключ без значения');

            $table->timestamps(); // created_at / updated_at — когда мета создана/обновлена

            $table->unique(['message_id', 'meta_key']);      // один ключ на сообщение
            $table->index(['meta_key', 'meta_value']);       // быстрый поиск по ключу/значению

            $table->comment('Ключ-значение метаданных сообщений (гибкая схема без JSON)');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_metas');
    }
};
