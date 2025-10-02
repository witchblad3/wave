<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'room_id',
        'user_id',
        'body',
        'type',
        'system_code',
        'reply_to_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(self::class, 'reply_to_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'reply_to_id');
    }

    public function attachments()
    {
        return $this->hasMany(MessageAttachment::class);
    }

    public function meta()
    {
        return $this->hasMany(MessageMeta::class);
    }

    public function scopeInRoom($q, int $roomId)
    {
        return $q->where('room_id', $roomId);
    }

    public function scopeNotSystem($q)
    {
        return $q->where('type', '!=', 'system');
    }

    public function scopeOfType($q, string $type)
    {
        return $q->where('type', $type);
    }

    public function getIsSystemAttribute(): bool
    {
        return $this->type === 'system';
    }
}
