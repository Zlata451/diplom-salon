<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Редагувати послугу</h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-6">
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.services.update', $service) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium">Назва:</label>
                <input type="text" name="name" value="{{ old('name', $service->name) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Опис:</label>
                <textarea name="description" class="w-full border rounded px-3 py-2" rows="4" required>{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Ціна:</label>
                <input type="number" name="price" step="0.01" value="{{ old('price', $service->price) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Тривалість (хв.):</label>
                <input type="number" name="duration" value="{{ old('duration', $service->duration) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <x-primary-button>Зберегти</x-primary-button>
            <a href="{{ route('admin.services.index') }}" class="ml-4 text-blue-500 hover:underline">⬅ Назад</a>
        </form>
    </div>
</x-app-layout>
