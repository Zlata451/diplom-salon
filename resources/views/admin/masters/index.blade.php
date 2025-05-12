<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 Список майстрів
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-6xl mx-auto">
        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 p-4 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.masters.create') }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                ➕ Додати майстра
            </a>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <table class="w-full table-auto border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Ім’я</th>
                        <th class="border px-4 py-2">Спеціалізація</th>
                        <th class="border px-4 py-2">Телефон</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Графік роботи</th>
                        <th class="border px-4 py-2">Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($masters as $master)
                        <tr>
                            <td class="border px-4 py-2">{{ $master->name }}</td>
                            <td class="border px-4 py-2">{{ $master->specialty }}</td>
                            <td class="border px-4 py-2">{{ $master->phone ?? '—' }}</td>
                            <td class="border px-4 py-2">{{ $master->email ?? '—' }}</td>
                            <td class="border px-4 py-2 text-sm leading-snug">
                                @php
                                    $daysUa = [
                                        'monday' => 'Пн',
                                        'tuesday' => 'Вт',
                                        'wednesday' => 'Ср',
                                        'thursday' => 'Чт',
                                        'friday' => 'Пт',
                                        'saturday' => 'Сб',
                                        'sunday' => 'Нд',
                                    ];
                                @endphp
                                @forelse($master->workingHours as $wh)
                                    <div>
                                        <strong>{{ $daysUa[$wh->day_of_week] ?? $wh->day_of_week }}:</strong>
                                        {{ \Carbon\Carbon::parse($wh->start_time)->format('H:i') }}
                                        —
                                        {{ \Carbon\Carbon::parse($wh->end_time)->format('H:i') }}
                                    </div>
                                @empty
                                    <span class="text-gray-400 italic">немає даних</span>
                                @endforelse
                            </td>
                            <td class="border px-4 py-2 space-y-2 text-center">
                                <a href="{{ route('admin.masters.edit', $master->id) }}"
                                   class="text-blue-600 hover:underline block">✏️ Редагувати</a>

                                <form action="{{ route('admin.masters.destroy', $master->id) }}"
                                      method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити цього майстра?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline block">
                                        🗑️ Видалити
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">Майстрів поки немає.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
