<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class MessageAttachment extends Model
{
    protected $fillable = [
        'message_id',
        'kind',
        'disk',
        'path',
        'original_name',
        'mime',
        'size',
        'width',
        'height',
        'duration_seconds',
        'status',
    ];

    protected $casts = [
        'size' => 'int',
        'width' => 'int',
        'height' => 'int',
        'duration_seconds' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['url'];

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    public function scopeOfKind($q, string $kind)  { return $q->where('kind', $kind); }
    public function scopeReady($q)                 { return $q->where('status', 'ready'); }
}
