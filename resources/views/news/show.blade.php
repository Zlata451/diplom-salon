<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $news->title }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto bg-white shadow rounded p-6 space-y-4">
        <p class="text-sm text-gray-500">{{ $news->published_at?->format('d.m.Y') }}</p>
        <div class="text-gray-800 leading-relaxed">
            {!! nl2br(e($news->content)) !!}
        </div>

        <a href="{{ route('news.index') }}" class="inline-block text-indigo-600 hover:underline">← Назад до списку</a>
    </div>
</x-app-layout>
