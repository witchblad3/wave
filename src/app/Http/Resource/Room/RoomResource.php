<?php

namespace App\Http\Resource\Room;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RoomResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'is_private' => $this->is_private,
            'image_url' => Storage::disk($this->image_disk)->url($this->image),
            'owner' => $this->whenLoaded('owner', UserResource::class),
        ];
    }
}
