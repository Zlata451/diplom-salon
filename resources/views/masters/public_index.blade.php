<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Наші майстри') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $daysUa = [
                        'monday' => 'Понеділок',
                        'tuesday' => 'Вівторок',
                        'wednesday' => 'Середа',
                        'thursday' => 'Четвер',
                        'friday' => 'Пʼятниця',
                        'saturday' => 'Субота',
                        'sunday' => 'Неділя',
                    ];

                    function pluralUkr($count) {
                        $mod10 = $count % 10;
                        $mod100 = $count % 100;

                        if ($mod10 == 1 && $mod100 != 11) return 'відгук';
                        if ($mod10 >= 2 && $mod10 <= 4 && ($mod100 < 10 || $mod100 >= 20)) return 'відгуки';
                        return 'відгуків';
                    }
                @endphp

                @forelse ($masters as $master)
                    <div class="bg-white p-6 rounded-lg shadow text-center">
                        {{-- Фото майстра --}}
                        @if ($master->photo)
                            <img src="{{ asset('storage/masters/' . basename($master->photo)) }}"
                                 alt="{{ $master->name }}"
                                 class="w-full h-60 object-cover rounded mb-4">
                        @else
                            <div class="w-full h-60 bg-gray-200 rounded mb-4 flex items-center justify-center text-gray-500">
                                Фото відсутнє
                            </div>
                        @endif

                        {{-- Інформація --}}
                        <h3 class="text-lg font-semibold text-indigo-700">{{ $master->name }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $master->specialty }}</p>

                        @if($master->phone)
                            <p class="text-sm text-gray-500 mt-2">📞 {{ $master->phone }}</p>
                        @endif

                        @if($master->email)
                            <p class="text-sm text-gray-500">✉️ {{ $master->email }}</p>
                        @endif

                        {{-- ⭐ Рейтинг --}}
                        @php
                            $reviewCount = $master->reviews->count();
                            $averageRating = $reviewCount > 0
                                ? round($master->reviews->avg('rating'), 1)
                                : null;
                        @endphp

                        @if ($reviewCount > 0)
                            <p class="text-yellow-500 text-sm mt-2">
                                ⭐ {{ $averageRating }} / 5 ({{ $reviewCount }} {{ pluralUkr($reviewCount) }})
                            </p>
                        @endif

                        {{-- Графік роботи --}}
                        @if ($master->workingHours->count())
                            <div class="mt-4 text-sm text-left">
                                <p class="font-semibold text-gray-700 mb-1">🕒 Графік роботи:</p>
                                <ul class="space-y-1 text-gray-600">
                                    @foreach ($master->workingHours as $wh)
                                        <li>
                                            {{ $daysUa[$wh->day_of_week] ?? ucfirst($wh->day_of_week) }}:
                                            {{ \Carbon\Carbon::parse($wh->start_time)->format('H:i') }} —
                                            {{ \Carbon\Carbon::parse($wh->end_time)->format('H:i') }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="mt-4 text-sm text-gray-400">Графік роботи не вказано</p>
                        @endif

                        {{-- Кнопки --}}
                        <div class="mt-4 flex justify-center gap-3">
                            <a href="{{ route('appointments.bookWithMaster', ['master' => $master->id]) }}"
                               class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">
                                📝 Записатися
                            </a>

                            <a href="{{ route('masters.show', $master->id) }}"
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded border border-gray-300">
                                ℹ️ Детальніше →
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-full text-center">Наразі майстрів немає 🥲</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
