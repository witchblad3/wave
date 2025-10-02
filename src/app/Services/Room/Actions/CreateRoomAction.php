<?php

namespace App\Services\Room\Actions;

use App\Repositories\Read\User\UserReadRepositoryInterface;
use Illuminate\Support\Collection;

readonly class CreateRoomAction
{
    public function __construct(
        private UserReadRepositoryInterface $userReadRepository
    ) {
    }

    public function run(?int $currentUserId = null): Collection
    {
        return $this->userReadRepository->getAvailableRoomParticipants($currentUserId);
    }
}
