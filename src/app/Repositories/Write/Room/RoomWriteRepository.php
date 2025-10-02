<?php
namespace App\Repositories\Write\Room;

use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;

class RoomWriteRepository implements RoomWriteRepositoryInterface
{
    private function query(): Builder
    {
        return Room::query();
    }
    public function create($data,): Room
    {
        return $this->query()->create($data);
    }

    public function attachMember(Room $room, int $userId, string $role = 'member'): void
    {
        $room->members()->syncWithoutDetaching([
            $userId => ['role' => $role],
        ]);
    }
}
