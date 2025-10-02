<?php

namespace App\Models;

use App\Services\Room\Dto\StoreRoomDto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_private',
        'image',
        'owner_id',
        'slug',
        'password_hash',
    ];

    protected $hidden = ['password_hash'];

    protected $casts = [
        'is_private' => 'bool',
    ];

    public static function createModel(StoreRoomDto $dto,$imagePath,$slug,$passwordHash,$disk): array
    {
        return [
            'name' => $dto->name,
            'description' => $dto->description,
            'is_private' => $dto->isPrivate,
            'image' => $imagePath,
            'owner_id' => $dto->ownerId,
            'slug' => $slug,
            'password_hash' => $passwordHash,
            'image_disk' => $disk,
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'room_users') // <-- имя pivot
        ->withPivot('role')
            ->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

//    public function roomUsers()
//    {
//        return $this->hasMany(RoomUser::class);
//    }

    public function latestMessage(): hasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) return null;
        return Storage::disk('public')->url($this->image);
    }
}
