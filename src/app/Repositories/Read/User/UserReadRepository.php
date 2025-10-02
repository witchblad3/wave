<?php

namespace App\Repositories\Read\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UserReadRepository implements UserReadRepositoryInterface
{
    private function query(): Builder
    {
        return User::query();
    }

    public function getAvailableRoomParticipants(?int $excludeUserId = null): Collection
    {
        return $this->query()
            ->when($excludeUserId, fn (Builder $query) => $query->where('id', '!=', $excludeUserId))
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
    }
}
