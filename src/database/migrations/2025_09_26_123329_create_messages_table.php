<?php

use App\Enum\Message\MessageTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id()->comment('Первичный ключ сообщения');

            $table->foreignId('room_id')
                ->constrained()
                ->cascadeOnDelete(); //('ID комнаты (rooms.id), к которой относится сообщение');

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete(); //('ID автора сообщения (users.id)');

            $table->text('body')
                ->nullable()
                ->comment('Текст сообщения. Может быть NULL для чисто файловых/голосовых/системных сообщений');

            $table->enum('type', MessageTypeEnum::values())
                ->default('text')
                ->index()
                ->comment(
                    "Тип сообщения:\n".
                    " - text   — обычный текст (в т.ч. может иметь вложения-изображения/файлы в связанной таблице);\n".
                    " - file   — сообщение, сущность которого — файл/картинка/видео (есть вложения);\n".
                    " - voice  — голосовое сообщение (вложение аудио, длительность и т.п. в attachments/meta);\n".
                    " - video  — видео сообщение (вложение видео, длительность и т.п. в attachments/meta);\n".
                    " - system — служебное событие (вход/выход участника, переименование комнаты и т.д.)."
                );

            $table->string('system_code')
                ->nullable()
                ->index()
                ->comment('Код системного события (например: user_joined, room_renamed). NULL для несистемных сообщений');

            $table->foreignId('reply_to_id')
                ->nullable()
                ->constrained('messages')
                ->nullOnDelete(); //('Ответ на другое сообщение (messages.id). NULL, если не является ответом');

            $table->softDeletes(); // deleted_at — мягкое удаление
            $table->timestamps();  // created_at, updated_at

            $table->index(['room_id', 'created_at']); // частые выборки ленты сообщений по комнате
            $table->comment('Сообщения комнат (текстовые, файловые, голосовые и системные)');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
