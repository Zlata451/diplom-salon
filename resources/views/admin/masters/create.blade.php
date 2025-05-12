<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Додати майстра
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-3xl mx-auto">
        @if ($errors->any())
            <div class="mb-4 text-red-600 bg-red-100 border-l-4 border-red-500 p-4 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.masters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 bg-white p-6 rounded shadow">
            @csrf

            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">Ім’я майстра:</label>
                <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label for="specialty" class="block font-medium text-sm text-gray-700">Спеціалізація:</label>
                <input type="text" name="specialty" id="specialty" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label for="phone" class="block font-medium text-sm text-gray-700">Телефон:</label>
                <input type="text" name="phone" id="phone" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label for="email" class="block font-medium text-sm text-gray-700">Email:</label>
                <input type="email" name="email" id="email" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label for="photo" class="block font-medium text-sm text-gray-700">Фото:</label>
                <input type="file" name="photo" id="photo" accept="image/*" class="w-full mt-1">
            </div>

            <!-- 📋 Послуги майстра -->
            <div>
                <label class="block font-medium text-sm text-gray-700 mb-2">Послуги майстра:</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($services as $service)
                        <label class="flex items-center space-x-2">
                            <input
                                type="checkbox"
                                name="services[]"
                                value="{{ $service->id }}"
                                {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                            >
                            <span>{{ $service->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 🕒 Графік роботи -->
            <div>
                <label class="block font-medium text-sm text-gray-700 mb-2">Графік роботи:</label>
                @foreach ([
                    'monday' => 'Понеділок',
                    'tuesday' => 'Вівторок',
                    'wednesday' => 'Середа',
                    'thursday' => 'Четвер',
                    'friday' => 'Пʼятниця',
                    'saturday' => 'Субота',
                    'sunday' => 'Неділя'
                ] as $key => $label)
                    <div class="mb-2 flex items-center gap-4">
                        <label class="w-24">{{ $label }}:</label>
                        <input type="time" name="working_hours[{{ $key }}][start_time]" class="border rounded px-2 py-1">
                        <span>–</span>
                        <input type="time" name="working_hours[{{ $key }}][end_time]" class="border rounded px-2 py-1">
                        <label class="ml-4 flex items-center space-x-2">
                            <input type="hidden" name="working_hours[{{ $key }}][day_off]" value="0">
                            <input type="checkbox" name="working_hours[{{ $key }}][day_off]" value="1">
                            <span>Вихідний</span>
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="flex items-center">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    💾 Зберегти
                </button>
                <a href="{{ route('admin.masters.index') }}" class="ml-4 text-blue-500 hover:underline">← Назад до списку</a>
            </div>
        </form>
    </div>
</x-app-layout>
