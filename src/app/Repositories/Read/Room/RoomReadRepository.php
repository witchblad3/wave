<?php
namespace App\Repositories\Read\Room;

use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomReadRepository implements RoomReadRepositoryInterface
{
    private function query(): Builder
    {
        return Room::query();
    }
    public function getAllRooms($relations = []): LengthAwarePaginator
    {
        return $this->query()
            ->with($relations)
            ->latest('rooms.created_at')
            ->paginate(20);
    }
    public function getRoomById(int $id, $relations = []): Room
    {
        return $this->query()->with($relations)->findOrFail($id);
    }
    public function getRoomBySlug(string $slug, $relations = []): Room
    {
        return $this->query()->with($relations)->where('slug', $slug)->firstOrFail();
    }
    public function existsBySlug(string $slug): bool
    {
        return $this->query()->where('slug', $slug)->exists();
    }
}
