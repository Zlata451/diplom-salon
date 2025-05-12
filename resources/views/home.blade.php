<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Головна') }}
        </h2>
    </x-slot>

    {{-- 🌸 Привітання --}}
    <div class="py-16 bg-gradient-to-br from-pink-50 to-pink-100">
        <div class="max-w-4xl mx-auto text-center px-4 space-y-6">
            <h1 class="text-5xl font-extrabold text-pink-700">
                Ласкаво просимо до нашого салону краси!
            </h1>
            <p class="text-xl text-gray-700">
                Ми робимо світ красивішим 💄✨<br>
                Запишіться до наших професіоналів та скористайтеся найкращими послугами вже сьогодні!
            </p>
        </div>
    </div>

    {{-- 📰 Останні новини --}}
    <div class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <h2 class="text-2xl font-bold text-gray-800">📰 Останні новини</h2>

            @forelse ($news as $item)
                <div class="bg-pink-50 p-6 rounded shadow-sm space-y-2">
                    <h3 class="text-xl font-semibold text-pink-700">{{ $item->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $item->published_at?->format('d.m.Y') }}</p>
                    <p class="text-gray-700">{{ \Illuminate\Support\Str::limit($item->content, 200) }}</p>
                    <a href="{{ route('news.show', $item) }}" class="text-pink-600 hover:underline">Читати далі →</a>
                </div>
            @empty
                <p class="text-gray-500">Новин поки немає.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
