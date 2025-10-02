<?php

namespace App\Repositories\Read\Room;

use App\Models\Room;
use Illuminate\Pagination\LengthAwarePaginator;

interface RoomReadRepositoryInterface
{
    public function getAllRooms($relations = []): LengthAwarePaginator;
    public function getRoomById(int $id, $relations = []): Room;
    public function getRoomBySlug(string $slug, $relations = []): Room;
    public function existsBySlug(string $slug): bool;
}
