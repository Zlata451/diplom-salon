<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Додати нову послугу
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('admin.services.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Назва</label>
                <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Опис</label>
                <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Ціна (грн)</label>
                <input type="number" step="0.01" name="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Тривалість (хв)</label>
                <input type="number" name="duration" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>

            <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">
                💾 Додати послугу
            </button>
        </form>
    </div>
</x-app-layout>
