<?php

namespace App\Repositories\Read\User;

use Illuminate\Support\Collection;

interface UserReadRepositoryInterface
{
    public function getAvailableRoomParticipants(?int $excludeUserId = null): Collection;
}
