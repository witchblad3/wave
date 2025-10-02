<?php

namespace App\Services\Room\Actions;
use App\Repositories\Read\Room\RoomReadRepositoryInterface;
readonly class IndexRoomAction
{
    public function __construct(
        private RoomReadRepositoryInterface $roomsReadRepository
    )
    {
    }

    public function run(){
        return $this->roomsReadRepository->getAllRooms(['owner']);
    }
}
