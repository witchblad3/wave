<?php
// app/Http/Resources/UserResource.php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            // пример для аватара (раскомментируй и адаптируй поле/диск):
            // 'avatar_url' => $this->avatar ? \Storage::disk('public')->url($this->avatar) : null,
        ];
    }
}
