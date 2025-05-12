<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            ✏️ Редагувати: {{ $about->section === 'intro' ? 'Дипломне пояснення' : 'Про салон' }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.about.update', $about->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">
                    {{ $about->section === 'intro' ? 'Текст дипломного пояснення' : 'Текст про салон' }}:
                </label>
                <textarea name="content" id="content" rows="10" class="mt-1 block w-full border-gray-300 rounded shadow-sm">{{ old('content', $about->content) }}</textarea>
                @error('content')
                    <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <x-primary-button>💾 Зберегти</x-primary-button>
        </form>
    </div>
</x-app-layout>
