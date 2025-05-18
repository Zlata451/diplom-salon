<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $master->name }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4 space-y-6">
        {{-- 📸 Фото майстра --}}
        @if ($master->photo)
            <img src="{{ asset('storage/masters/' . basename($master->photo)) }}" alt="{{ $master->name }}" class="w-full h-72 object-cover rounded shadow">
        @endif

        {{-- 👤 Інформація --}}
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-bold text-indigo-700">{{ $master->specialty }}</h3>
            @if ($master->phone)
                <p class="text-sm text-gray-600 mt-2">📞 {{ $master->phone }}</p>
            @endif
            @if ($master->email)
                <p class="text-sm text-gray-600">✉️ {{ $master->email }}</p>
            @endif
        </div>

        {{-- 🕒 Графік роботи --}}
        @if ($master->workingHours->count())
            <div class="bg-white p-6 rounded shadow">
                <h4 class="font-semibold mb-2 text-gray-800">🕒 Графік роботи</h4>
                <ul class="text-sm text-gray-700 space-y-1">
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
                    @endphp
                    @foreach ($master->workingHours as $wh)
                        <li>
                            {{ $daysUa[$wh->day_of_week] ?? ucfirst($wh->day_of_week) }}:
                            {{ \Carbon\Carbon::parse($wh->start_time)->format('H:i') }} — {{ \Carbon\Carbon::parse($wh->end_time)->format('H:i') }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 📝 Кнопка запису --}}
        <div class="text-right">
            <a href="{{ route('appointments.bookWithMaster', $master->id) }}"
               class="inline-block bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded text-sm">
                📝 Записатися до майстра
            </a>
        </div>

        {{-- 💬 Відгуки --}}
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">💬 Відгуки клієнтів:</h3>

            @forelse ($master->reviews as $review)
                <div class="mb-4 border-b pb-2">
                    <div class="text-sm text-gray-700">
                        ⭐ {{ $review->rating }}/5
                        <p class="mt-1">{{ $review->comment }}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">— {{ $review->user->name }}</p>

                    {{-- 🗑️ Видалити (тільки для адміна) --}}
                    @auth
                        @if(auth()->user()->role === 'admin' && Route::has('admin.reviews.destroy'))
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:underline text-xs"
                                        onclick="return confirm('Ви впевнені, що хочете видалити цей відгук?');">
                                    🗑️ Видалити
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            @empty
                <p class="text-sm text-gray-500">Немає ще жодного відгуку.</p>
            @endforelse
        </div>

        {{-- ➕ Додати відгук --}}
        @auth
            <div class="bg-white p-6 rounded shadow">
                <h4 class="text-gray-800 font-semibold mb-2">📝 Залишити відгук:</h4>
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="master_id" value="{{ $master->id }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Оцінка:</label>
                        <select name="rating" required class="border rounded px-2 py-1 w-28 mb-3">
                            <option value="">— Оберіть —</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }} ⭐</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ваш коментар:</label>
                        <textarea name="comment" rows="3" class="w-full border rounded px-3 py-2 mb-2" required></textarea>
                    </div>

                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        💬 Надіслати
                    </button>
                </form>
            </div>
        @endauth
    </div>

    <div class="text-center mt-6">
        <a href="{{ route('masters.index') }}"
           class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
            ← Назад до всіх майстрів
        </a>
    </div>
</x-app-layout>
