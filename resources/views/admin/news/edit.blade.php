<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Редагувати новину</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <form action="{{ route('admin.news.update', $news) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block font-medium">Заголовок</label>
                <input type="text" id="title" name="title" class="w-full border rounded p-2"
                       value="{{ old('title', $news->title) }}" required>
            </div>

            <div>
                <label for="type" class="block font-medium">Тип</label>
                <select name="type" id="type" class="w-full border rounded p-2">
                    <option value="новина" {{ $news->type === 'новина' ? 'selected' : '' }}>Новина</option>
                    <option value="акція" {{ $news->type === 'акція' ? 'selected' : '' }}>Акція</option>
                    <option value="новинка" {{ $news->type === 'новинка' ? 'selected' : '' }}>Новинка</option>
                </select>
            </div>

            <div>
                <label for="content" class="block font-medium">Текст</label>
                <textarea name="content" id="content" rows="5" class="w-full border rounded p-2" required>{{ old('content', $news->content) }}</textarea>
            </div>

            <div>
                <label for="published_at" class="block font-medium">Дата публікації</label>
                <input type="date" name="published_at" id="published_at" class="w-full border rounded p-2"
                       value="{{ old('published_at', optional($news->published_at)->format('Y-m-d')) }}">
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    💾 Оновити
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
