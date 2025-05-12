<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Редагувати Контакти</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.contact.update', $contact) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Контактна інформація:</label>
                <textarea name="content" id="content" rows="12" class="mt-1 block w-full border-gray-300 rounded shadow-sm">{{ old('content', $contact->content) }}</textarea>
                @error('content')
                    <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <x-primary-button>💾 Зберегти</x-primary-button>
        </form>
    </div>
</x-app-layout>
