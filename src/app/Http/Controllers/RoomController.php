<?php

namespace App\Http\Controllers;

use App\Http\Requests\Room\StoreRoomRequest;
use App\Models\User;
use App\Services\Room\Actions\IndexRoomAction;
use App\Services\Room\Actions\StoreRoomAction;
use App\Services\Room\Dto\StoreRoomDto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory;
;

class RoomController extends Controller
{
    /**
     * @param IndexRoomAction $action
     * @return Factory|View
     */
    public function index(IndexRoomAction $action): Factory|View
    {
        $result = $action->run();
        return view('rooms.index', compact('result'));
    }

    public function create()
    {
        $currentUserId = auth()->id();

        $users = User::query()
            ->when($currentUserId, fn ($query) => $query->where('id', '!=', $currentUserId))
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('rooms.create', [
            'users' => $users,
        ]);
    }

    /**
     * @param StoreRoomRequest $request
     * @param StoreRoomAction $action
     * @return RedirectResponse
     */
    public function store(
        StoreRoomRequest $request,
        StoreRoomAction $action
    ): RedirectResponse
    {
        $dto = StoreRoomDto::fromRequest($request);
        $result = $action->run($dto);
        return redirect()->route('rooms.index')
            ->with('status', "Комната «{$result->name}» создана");
    }
//
//    public function show(string $slug)
//    {
//        $room = $this->roomsRead->findBySlug($slug, ['owner','latestMessage.user']);
//        abort_if(!$room, 404);
//        return RoomResource::make($room);
//    }
//
//    public function join(JoinRoomRequest $request)
//    {
//        $dto  = JoinRoomDto::fromRequest($request);
//        $room = $this->joinRoom->run($dto, $request->user());
//        return RoomResource::make($room);
//    }
}
