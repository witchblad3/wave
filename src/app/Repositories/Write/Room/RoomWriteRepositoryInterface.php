<?php

namespace App\Repositories\Write\Room;

use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;

interface RoomWriteRepositoryInterface
{
    public function create($data): Room;
    public function attachMember(Room $room, int $userId, string $role = 'member'): void;
}
