<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Новини та Акції') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto space-y-6">
        @forelse ($news as $item)
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-2xl font-bold text-indigo-700">{{ $item->title }}</h3>
                <p class="text-sm text-gray-500">{{ $item->published_at?->format('d.m.Y') }}</p>
                <p class="mt-2 text-gray-700">{{ \Illuminate\Support\Str::limit($item->content, 150) }}</p>

                <a href="{{ route('news.show', $item) }}" class="mt-4 inline-block text-indigo-600 hover:underline">
                    Детальніше →
                </a>
            </div>
        @empty
            <p class="text-gray-500 text-center">Новин поки що немає 😔</p>
        @endforelse
    </div>
</x-app-layout>
