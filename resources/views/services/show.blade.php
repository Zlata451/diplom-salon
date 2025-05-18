<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ $service->name }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-4xl mx-auto space-y-6">
        {{-- ✅ Повідомлення про успіх --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- 📋 Інформація про послугу --}}
        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-700 text-sm mb-2">{{ $service->description }}</p>
            <div class="text-sm text-gray-600">
                <p><strong>Ціна:</strong> {{ $service->price }} грн</p>
                <p><strong>Тривалість:</strong> {{ $service->duration }} хв</p>
            </div>

            <div class="mt-4">
                <a href="{{ route('appointments.book', $service->id) }}"
                   class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    📝 Записатися
                </a>
            </div>
        </div>

        {{-- 💬 Відгуки --}}
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">💬 Відгуки клієнтів:</h3>

            @forelse ($service->reviews as $review)
                <div class="mb-4 border-b pb-2">
                    <div class="text-sm text-gray-700">
                        ⭐ {{ $review->rating }}/5
                        <p class="mt-1">{{ $review->comment }}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">— {{ $review->user->name }}</p>

                    {{-- 🗑️ Видалити (тільки для адміна) --}}
                    @auth
                        @if(auth()->user()->role === 'admin')
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
                <p class="text-sm text-gray-500">Поки що немає жодного відгуку.</p>
            @endforelse
        </div>

        {{-- ➕ Додати відгук --}}
        @auth
            <div class="bg-white p-6 rounded shadow">
                <h4 class="text-gray-800 font-semibold mb-2">📝 Залишити відгук:</h4>
                <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Рейтинг:</label>
                        <select name="rating" required class="border rounded px-2 py-1 w-28">
                            <option value="">— Оберіть —</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }} ⭐</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Коментар:</label>
                        <textarea name="comment" rows="3" class="w-full border rounded px-3 py-2" placeholder="Напишіть ваші враження..." required></textarea>
                    </div>

                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        💬 Надіслати відгук
                    </button>
                </form>
            </div>
        @endauth
    </div>

    <div class="text-center mt-6">
        <a href="{{ route('services.index') }}"
           class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
            ← Назад до всіх послуг
        </a>
    </div>



</x-app-layout>
