<?php

namespace App\Enum\Message;

enum MessageTypeEnum: string
{
    case VOICE = 'single';
    case IMAGE = 'image';
    case VIDEO = 'video';
    case FILE = 'file';
    case TEXT = 'text';
    case SYSTEM = 'system';

    public function label(): string
    {
        return match ($this) {
            self::VOICE => 'голосовое сообщение',
            self::IMAGE => 'изображение',
            self::FILE => 'файл',
            self::VIDEO => 'видео',
            self::TEXT => 'текст',
            self::SYSTEM => 'системное сообщение',
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'label' => $case->label(),
            'value' => $case->value,
        ], self::cases());
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
