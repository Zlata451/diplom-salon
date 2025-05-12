<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            📋 Записи клієнтів
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            {{-- ✅ Повідомлення про успіх --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            {{-- 🔽 Фільтр по статусу --}}
            <form method="GET" action="{{ route('appointments.index') }}" class="mb-4 flex items-center space-x-4">
                <label for="status" class="text-sm text-gray-700">Фільтрувати за статусом:</label>
                <select name="status" id="status" onchange="this.form.submit()"
                        class="rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">— Усі —</option>
                    <option value="заплановано" {{ request('status') === 'заплановано' ? 'selected' : '' }}>📅 Заплановано</option>
                    <option value="завершено" {{ request('status') === 'завершено' ? 'selected' : '' }}>✅ Завершено</option>
                    <option value="скасовано" {{ request('status') === 'скасовано' ? 'selected' : '' }}>❌ Скасовано</option>
                </select>
            </form>

            <div class="overflow-x-auto bg-white p-6 shadow-sm sm:rounded-lg">
                <table class="min-w-full table-auto border">
                    <thead>
                        <tr class="bg-gray-100 text-sm text-gray-700">
                            <th class="border px-4 py-2">#</th>
                            <th class="border px-4 py-2">Клієнт</th>
                            <th class="border px-4 py-2">Послуга</th>
                            <th class="border px-4 py-2">Майстер</th>
                            <th class="border px-4 py-2">Дата</th>
                            <th class="border px-4 py-2">Час</th>
                            <th class="border px-4 py-2">Статус</th>
                            <th class="border px-4 py-2">Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr class="text-sm text-gray-800">
                                <td class="border px-4 py-2">{{ $appointment->id }}</td>
                                <td class="border px-4 py-2">{{ $appointment->user->name }}</td>
                                <td class="border px-4 py-2">{{ $appointment->service->name }}</td>
                                <td class="border px-4 py-2">{{ $appointment->master->name }}</td>
                                <td class="border px-4 py-2">{{ $appointment->date }}</td>
                                <td class="border px-4 py-2">{{ $appointment->time }}</td>

                                <td class="border px-4 py-2">
                                    <form action="{{ route('appointments.updateStatus', $appointment->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex items-center space-x-2">
                                            <select name="status" class="rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                                                <option value="заплановано" {{ $appointment->status === 'заплановано' ? 'selected' : '' }}>📅 Заплановано</option>
                                                <option value="завершено" {{ $appointment->status === 'завершено' ? 'selected' : '' }}>✅ Завершено</option>
                                                <option value="скасовано" {{ $appointment->status === 'скасовано' ? 'selected' : '' }}>❌ Скасовано</option>
                                            </select>
                                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">💾</button>
                                        </div>
                                    </form>
                                </td>

                                <td class="border px-4 py-2 space-y-1 text-center">
                                    {{-- 🔁 Повторити запис --}}
                                    @if(in_array($appointment->status, ['завершено', 'скасовано']))
                                        <a href="{{ route('appointments.bookWithMaster', $appointment->master->id) }}?service_id={{ $appointment->service->id }}"
                                           class="inline-block text-blue-600 hover:underline text-sm">
                                            🔁 Повторити
                                        </a>
                                    @endif

                                    {{-- ✏️ Редагувати --}}
                                    <a href="{{ route('appointments.edit', $appointment) }}"
                                       class="inline-block text-yellow-600 hover:underline text-sm">
                                        ✏️ Редагувати
                                    </a>

                                    {{-- 🗑️ Видалити --}}
                                    <form action="{{ route('appointments.destroy', $appointment) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Ви впевнені, що хочете видалити цей запис?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm">
                                            🗑️ Видалити
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="border px-4 py-4 text-center text-gray-500">
                                    Записів поки що немає.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
