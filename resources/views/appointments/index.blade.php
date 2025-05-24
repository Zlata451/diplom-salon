<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            📋 Записи клієнтів
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            {{-- ✅ Flash-повідомлення --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ✅ Дії для адміна --}}
            <div class="flex justify-end mb-4 space-x-3">
                <form action="{{ route('admin.appointments.updateStatuses') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                        🔄 Оновити статуси
                    </button>
                </form>

                <form action="{{ route('admin.appointments.sendReminders') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        💬 Надіслати нагадування
                    </button>
                </form>
            </div>

            {{-- 🔍 Фільтр --}}
            <form method="GET" action="{{ route('appointments.index') }}" class="mb-4 flex flex-wrap items-end gap-4 bg-white p-4 rounded shadow-sm">
                {{-- Статус --}}
                <div>
                    <label for="status" class="block text-sm text-gray-700">Статус</label>
                    <select name="status" id="status" class="rounded border-gray-300">
                        <option value="">— Усі —</option>
                        <option value="заплановано" {{ request('status') === 'заплановано' ? 'selected' : '' }}>📅 Заплановано</option>
                        <option value="завершено" {{ request('status') === 'завершено' ? 'selected' : '' }}>✅ Завершено</option>
                        <option value="скасовано" {{ request('status') === 'скасовано' ? 'selected' : '' }}>❌ Скасовано</option>
                    </select>
                </div>

                {{-- Дата --}}
                <div>
                    <label for="date" class="block text-sm text-gray-700">Дата</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}" class="rounded border-gray-300">
                </div>

                {{-- Майстер --}}
                <div>
                    <label for="master_id" class="block text-sm text-gray-700">Майстер</label>
                    <select name="master_id" id="master_id" class="rounded border-gray-300">
                        <option value="">— Усі —</option>
                        @foreach($masters as $master)
                            <option value="{{ $master->id }}" {{ request('master_id') == $master->id ? 'selected' : '' }}>
                                {{ $master->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Послуга --}}
                <div>
                    <label for="service_id" class="block text-sm text-gray-700">Послуга</label>
                    <select name="service_id" id="service_id" class="rounded border-gray-300">
                        <option value="">— Усі —</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" class="mt-5 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        🔍 Фільтрувати
                    </button>
                </div>
            </form>

            {{-- 📋 Таблиця --}}
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
                                            <select name="status" class="rounded border-gray-300 shadow-sm">
                                                <option value="заплановано" {{ $appointment->status === 'заплановано' ? 'selected' : '' }}>📅 Заплановано</option>
                                                <option value="завершено" {{ $appointment->status === 'завершено' ? 'selected' : '' }}>✅ Завершено</option>
                                                <option value="скасовано" {{ $appointment->status === 'скасовано' ? 'selected' : '' }}>❌ Скасовано</option>
                                            </select>
                                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">💾</button>
                                        </div>
                                    </form>
                                </td>

                                <td class="border px-4 py-2 space-y-1 text-center">
                                    @if(in_array($appointment->status, ['завершено', 'скасовано']))
                                        <a href="{{ route('appointments.bookWithMaster', $appointment->master->id) }}?service_id={{ $appointment->service->id }}"
                                           class="inline-block text-blue-600 hover:underline text-sm">
                                            🔁 Повторити
                                        </a>
                                    @endif

                                    <a href="{{ route('appointments.edit', $appointment) }}"
                                       class="inline-block text-yellow-600 hover:underline text-sm">
                                        ✏️ Редагувати
                                    </a>

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
