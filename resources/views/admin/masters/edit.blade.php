<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           ✏️ Редагувати майстра
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-2xl mx-auto">
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.masters.update', $master->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-medium">Ім’я майстра:</label>
                <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2"
                       value="{{ old('name', $master->name) }}" required>
            </div>

            <div>
                <label for="specialty" class="block font-medium">Спеціалізація:</label>
                <input type="text" name="specialty" id="specialty" class="w-full border rounded px-3 py-2"
                       value="{{ old('specialty', $master->specialty) }}" required>
            </div>

            <div>
                <label for="phone" class="block font-medium">Телефон:</label>
                <input type="text" name="phone" id="phone" class="w-full border rounded px-3 py-2"
                       value="{{ old('phone', $master->phone) }}">
            </div>

            <div>
                <label for="email" class="block font-medium">Email:</label>
                <input type="email" name="email" id="email" class="w-full border rounded px-3 py-2"
                       value="{{ old('email', $master->email) }}">
            </div>

            <div>
                <label class="block font-medium">Фото майстра:</label>
                @if ($master->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $master->photo) }}" alt="Фото майстра" class="h-32 rounded shadow">
                    </div>
                @endif
                <input type="file" name="photo" class="w-full">
                <p class="text-sm text-gray-500 mt-1">Завантаж нове фото, щоб замінити наявне (необов’язково).</p>
            </div>

            <div>
                <label class="block font-medium mb-2">Послуги майстра:</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($services as $service)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                   @checked($master->services->contains($service->id))>
                            <span>{{ $service->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <hr class="my-6">

            <h3 class="font-semibold text-lg text-gray-700">🗓️ Графік роботи</h3>

            @foreach ([
                'monday' => 'Понеділок',
                'tuesday' => 'Вівторок',
                'wednesday' => 'Середа',
                'thursday' => 'Четвер',
                'friday' => 'Пʼятниця',
                'saturday' => 'Субота',
                'sunday' => 'Неділя'
            ] as $day => $label)
                @php
                    $hours = $master->workingHours->firstWhere('day_of_week', $day);
                    $start = old("working_hours.$day.start_time", $hours?->start_time ? \Illuminate\Support\Str::limit($hours->start_time, 5, '') : null);
                    $end = old("working_hours.$day.end_time", $hours?->end_time ? \Illuminate\Support\Str::limit($hours->end_time, 5, '') : null);
                    $isDayOff = $start === null || $end === null;
                @endphp

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">{{ $label }}</label>
                    <div class="flex items-center gap-4">
                        <input type="time" name="working_hours[{{ $day }}][start_time]"
                               value="{{ $start }}"
                               class="border rounded px-3 py-1">

                        <span>—</span>

                        <input type="time" name="working_hours[{{ $day }}][end_time]"
                               value="{{ $end }}"
                               class="border rounded px-3 py-1">

                        <label class="flex items-center space-x-2 ml-4">
                            <input type="hidden" name="working_hours[{{ $day }}][day_off]" value="0">
                            <input type="checkbox" name="working_hours[{{ $day }}][day_off]" value="1"
                                   {{ $isDayOff ? 'checked' : '' }}
                                   onchange="this.closest('div').querySelectorAll('input[type=time]').forEach(el => {
                                       if (this.checked) {
                                           el.value = '';
                                       }
                                   })">
                            <span>Вихідний</span>
                        </label>
                    </div>
                </div>
            @endforeach

            <div class="pt-6">
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    💾 Зберегти зміни
                </button>
                <a href="{{ route('admin.masters.index') }}" class="ml-3 text-blue-500 hover:underline">⬅ Назад</a>
            </div>
        </form>
    </div>
</x-app-layout>
