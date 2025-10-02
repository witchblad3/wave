<?php

use App\Enum\Message\MessageTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('message_attachments', function (Blueprint $table) {
            $table->id()->comment('Первичный ключ вложения');

            $table->foreignId('message_id')
                ->constrained('messages')
                ->cascadeOnDelete(); // ID сообщения-владельца (messages.id)

            $table->enum('kind', MessageTypeEnum::values())
                ->index()
                ->comment('Тип вложения (например: file/image/voice/video). Значения берутся из MessageTypeEnum');

            $table->string('disk', 32)
                ->default('public')
                ->comment('Диск хранилища (filesystems.php): public/private/s3 и т.п.');

            $table->string('path', 512)
                ->comment('Относительный путь к файлу на выбранном диске (Storage)');

            $table->string('original_name', 255)
                ->nullable()
                ->comment('Оригинальное имя файла при загрузке (для отображения/скачивания)');

            $table->string('mime', 127)
                ->nullable()
                ->comment('MIME-тип файла (например image/png, audio/ogg)');

            $table->unsignedBigInteger('size')
                ->nullable()
                ->comment('Размер файла в байтах');

            $table->unsignedInteger('width')
                ->nullable()
                ->comment('Ширина изображения/видео в пикселях (если применимо)');

            $table->unsignedInteger('height')
                ->nullable()
                ->comment('Высота изображения/видео в пикселях (если применимо)');

            $table->decimal('duration_seconds', 8, 3)
                ->nullable()
                ->comment('Длительность аудио/видео в секундах (если применимо)');

            $table->string('waveform_path', 512)
                ->nullable()
                ->comment('Путь к предпросмотру волны/спектра (png/json), опционально для аудио');

            $table->enum('status', ['ready','processing','failed'])
                ->default('ready')
                ->index()
                ->comment('Статус вложения: готово/в обработке/ошибка (например после транскодинга)');

            $table->timestamps();

            $table->index(['message_id', 'id']); // ускорение выборок; индекс не комментируется в MySQL

            $table->comment('Вложения к сообщениям (файлы/изображения/голосовые/видео)');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_attachments');
    }
};
