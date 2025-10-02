<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        @if (session('status'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Комнаты</h1>
            <a href="{{ route('rooms.create') }}" class="px-3 py-2 rounded bg-indigo-600 text-white">+ Новая</a>
        </div>

        <div class="space-y-3">
            @forelse ($result as $room)
                @php
                    $cover = null;
                    if ($room->image) {
                        if ($room->is_private && \Illuminate\Support\Facades\Route::has('rooms.cover')) {
                            // защищённая раздача приватной обложки (если роут добавлен)
                            $cover = route('rooms.cover', $room->slug);
                        } elseif (! $room->is_private) {
                            // публичная обложка с public-диска
                            $cover = \Illuminate\Support\Facades\Storage::disk('public')->url($room->image);
                        }
                    }
                @endphp

                <div class="border rounded p-3 flex items-center gap-3">
                    @if($cover)
                        <img src="{{ $cover }}" alt="" class="w-12 h-12 rounded object-cover">
                    @else
                        <div class="w-12 h-12 rounded bg-gray-200 flex items-center justify-center text-gray-500">#</div>
                    @endif

                    <div class="flex-1">
                        <div class="font-medium">
                            {{ $room->name }}
                            @if($room->is_private)
                                <span class="ml-2 text-xs px-2 py-0.5 rounded bg-gray-200 text-gray-700 align-middle">private</span>
                            @endif
                        </div>
                        <div class="text-sm text-gray-600">{{ $room->description }}</div>
                    </div>
                </div>
            @empty
                <div class="text-gray-500">Комнат пока нет.</div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $result->links() }}
        </div>
    </div>
</x-app-layout>
