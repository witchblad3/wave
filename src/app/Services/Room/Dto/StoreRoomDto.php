<?php

namespace App\Services\Room\Dto;

use App\Models\User;
use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\Room\StoreRoomRequest;

class StoreRoomDto extends Data
{
        public string $name;
        public ?string $description;
        public bool $isPrivate;
        public ?string $password;
        public int $ownerId;
        public ?UploadedFile $image;
    public static function fromRequest(StoreRoomRequest $request): self
    {
        return self::from([
            'name' => $request->getName(),
            'description' => $request->getDescription(),
            'isPrivate' => $request->getIsPrivate(),
            'password' => $request->getPassword(),
            'image' => $request->getImage(),
            'ownerId' => $request->user()->id,
        ]);
    }
}
