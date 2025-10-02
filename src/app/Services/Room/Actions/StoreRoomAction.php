<?php

namespace App\Services\Room\Actions;

use App\Models\Room;
use App\Repositories\Read\Room\RoomReadRepositoryInterface;
use App\Repositories\Write\Room\RoomWriteRepositoryInterface;
use App\Services\Room\Dto\StoreRoomDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

readonly class StoreRoomAction
{
    private const OWNER = 'owner';
    private const PRIVATE = 'private';
    private const PUBLIC = 'public';
    private const ROOM = 'room';
    private const PATH = 'rooms/covers/';


    public function __construct(
        private RoomWriteRepositoryInterface $roomWriteRepository,
        private RoomReadRepositoryInterface $roomReadRepository
    )
    {
    }

    public function run(StoreRoomDto $dto): Room
    {
        $base = Str::slug($dto->name) ?: self::ROOM;
        $slug = $base;

        for ($i = 0; $this->roomReadRepository->existsBySlug($slug) && $i < 10; $i++) {
            $slug = $base . '-' . Str::lower(Str::random(4));
        }

        $disk = $dto->isPrivate ? self::PRIVATE : self::PUBLIC;

        $imagePath = $dto->image?->store(self::PATH . date('Y/m/d'), $disk);

        $passwordHash = $dto->isPrivate ? Hash::make($dto->password) : null;

        $room = $this->roomWriteRepository->create(Room::createModel($dto,$imagePath,$slug,$passwordHash,$disk));

        $this->roomWriteRepository->attachMember($room, $dto->ownerId, self::OWNER);

        $participantIds = array_unique(
            array_filter($dto->participantIds, fn ($id) => $id && $id !== $dto->ownerId)
        );

        foreach ($participantIds as $participantId) {
            $this->roomWriteRepository->attachMember($room, (int) $participantId);
        }

        return $room;
    }

}
