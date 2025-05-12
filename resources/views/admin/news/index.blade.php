<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Управління новинами</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <a href="{{ route('admin.news.create') }}" class="mb-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            ➕ Додати новину
        </a>

        <div class="bg-white p-6 rounded shadow">
            @forelse ($news as $item)
                <div class="mb-4 border-b pb-2">
                    <h3 class="text-lg font-bold">{{ $item->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $item->type }} • {{ $item->published_at?->format('d.m.Y') }}</p>

                    <div class="mt-2 flex gap-2">
                        <a href="{{ route('admin.news.edit', $item) }}" class="text-blue-600 hover:underline">Редагувати</a>
                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST" onsubmit="return confirm('Видалити цю новину?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Видалити</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Новин поки що немає.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
