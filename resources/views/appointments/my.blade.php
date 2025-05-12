<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Мої записи') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded shadow">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 🔍 Фільтр по статусу --}}
            <form method="GET" action="{{ route('appointments.my') }}" class="mb-6 flex items-center gap-4">
                <label for="status" class="font-medium text-sm text-gray-700">Фільтрувати за статусом:</label>
                <select name="status" id="status" onchange="this.form.submit()"
                        class="rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">— Всі —</option>
                    <option value="заплановано" {{ request('status') === 'заплановано' ? 'selected' : '' }}>📅 Заплановано</option>
                    <option value="завершено" {{ request('status') === 'завершено' ? 'selected' : '' }}>✅ Завершено</option>
                    <option value="скасовано" {{ request('status') === 'скасовано' ? 'selected' : '' }}>❌ Скасовано</option>
                </select>
            </form>

            <div class="overflow-x-auto bg-white p-6 shadow-sm sm:rounded-lg">
                <table class="min-w-full table-auto border">
                    <thead>
                        <tr class="bg-gray-100">
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
                            <tr>
                                <td class="border px-4 py-2">{{ $appointment->service->name }}</td>
                                <td class="border px-4 py-2">{{ $appointment->master->name }}</td>
                                <td class="border px-4 py-2">{{ $appointment->date }}</td>
                                <td class="border px-4 py-2">{{ $appointment->time }}</td>
                                <td class="border px-4 py-2">
                                    @if($appointment->status === 'заплановано')
                                        📅 Заплановано
                                    @elseif($appointment->status === 'завершено')
                                        ✅ Завершено
                                    @else
                                        ❌ Скасовано
                                    @endif
                                </td>
                                <td class="border px-4 py-2 text-center space-y-1">
                                    {{-- Кнопка "Повторити запис" тільки для завершено/скасовано --}}
                                    @if(in_array($appointment->status, ['завершено', 'скасовано']))
                                        <a href="{{ route('appointments.bookWithMaster', $appointment->master->id) }}?service_id={{ $appointment->service->id }}"
                                           class="inline-block text-blue-600 hover:underline text-sm">
                                            🔁 Повторити запис
                                        </a>
                                    @endif

                                    {{-- Кнопка "Скасувати" тільки для запланованих --}}
                                    @if($appointment->status === 'заплановано')
                                        <form action="{{ route('appointments.cancel', $appointment) }}" method="POST"
                                              onsubmit="return confirm('Ви впевнені, що хочете скасувати цей запис?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="text-red-600 hover:underline text-sm">
                                                Скасувати
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-4">Записів поки що немає.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
