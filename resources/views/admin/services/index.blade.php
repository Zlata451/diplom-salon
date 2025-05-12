<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Всі послуги
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('admin.services.create') }}" class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">
                ➕ Додати послугу
            </a>
        </div>

        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">Назва</th>
                    <th class="px-4 py-2 text-left">Опис</th>
                    <th class="px-4 py-2 text-left">Ціна (грн)</th>
                    <th class="px-4 py-2 text-left">Тривалість (хв)</th>
                    <th class="px-4 py-2 text-left">Дії</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $service->name }}</td>
                        <td class="px-4 py-2">{{ $service->description }}</td>
                        <td class="px-4 py-2">{{ $service->price }}</td>
                        <td class="px-4 py-2">{{ $service->duration }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.services.edit', $service->id) }}"
                               class="text-blue-600 hover:underline">Редагувати</a>

                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Ви впевнені, що хочете видалити цю послугу?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">Поки що немає жодної послуги 😔</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
