<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Новая комната
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-6">
        @if ($errors->any())
            <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rooms.store') }}" method="post" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Название</label>
                <input name="name" type="text" value="{{ old('name') }}" class="mt-1 w-full rounded border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium">Описание</label>
                <textarea name="description" rows="3" class="mt-1 w-full rounded border-gray-300">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center gap-2">
                <input id="is_private" name="is_private" type="checkbox" value="1" {{ old('is_private') ? 'checked' : '' }}>
                <label for="is_private" class="text-sm">Сделать комнату приватной</label>
            </div>

            <div>
                <label class="block text-sm font-medium">Пароль (для приватной)</label>
                <input name="password" type="password" class="mt-1 w-full rounded border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium">Подтверждение пароля</label>
                <input name="password_confirmation" type="password" class="mt-1 w-full rounded border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium">Обложка</label>
                <input name="image" type="file" accept="image/*" class="mt-1 block">
            </div>

            <input type="hidden" name="owner_id" value="{{ auth()->id() }}">

            <div class="flex gap-3">
                <a href="{{ route('rooms.index') }}" class="px-4 py-2 rounded border">Отмена</a>
                <button class="px-4 py-2 rounded bg-indigo-600 text-white">Создать</button>
            </div>
        </form>
    </div>
</x-app-layout>
