<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Наші послуги
        </h2>
    </x-slot>

    <div class="py-6 px-4 space-y-6">
        @forelse ($services as $service)
            <div class="border rounded p-4 shadow-sm bg-white">
                <h3 class="text-lg font-bold">{{ $service->name }}</h3>
                <p class="mt-2 text-sm text-gray-700">{{ $service->description }}</p>
                <div class="mt-2 text-sm">
                    <strong>Ціна:</strong> {{ $service->price }} грн<br>
                    <strong>Тривалість:</strong> {{ $service->duration }} хв.
                </div>
                <div class="mt-4">
                    <a href="{{ route('appointments.book', ['service' => $service->id]) }}"
                       class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        Записатися
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Поки що немає жодної послуги.</p>
        @endforelse
    </div>
</x-app-layout>
