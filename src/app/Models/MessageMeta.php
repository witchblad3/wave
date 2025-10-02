<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageMeta extends Model
{
    protected $fillable = [
        'message_id',
        'meta_key',
        'meta_value',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
