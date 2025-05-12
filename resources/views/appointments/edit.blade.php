<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            ✏️ Редагувати запис
        </h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto">
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('appointments.update', $appointment) }}">
            @csrf
            @method('PUT')

            {{-- Послуга (тільки для перегляду) --}}
            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Послуга</label>
                <input type="text" value="{{ $appointment->service->name }}" class="w-full border rounded px-3 py-2 bg-gray-100" disabled>
                <input type="hidden" name="service_id" value="{{ $appointment->service->id }}">
            </div>

            {{-- Майстер (тільки з тих, що надають послугу) --}}
            <div class="mb-4">
                <label for="master_id" class="block font-medium text-sm text-gray-700">Майстер</label>
                <select name="master_id" id="master_id" class="w-full border rounded px-3 py-2">
                    @foreach ($appointment->service->masters as $master)
                        <option value="{{ $master->id }}" @selected($appointment->master_id == $master->id)>
                            {{ $master->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Дата --}}
            <div class="mb-4">
                <label for="date" class="block font-medium text-sm text-gray-700">Дата</label>
                <input type="date" name="date" id="date" value="{{ old('date', $appointment->date) }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Час --}}
            <div class="mb-4">
                <label for="time" class="block font-medium text-sm text-gray-700">Час</label>
                <input type="time" name="time" id="time" value="{{ old('time', $appointment->time) }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Статус --}}
            <div class="mb-4">
                <label for="status" class="block font-medium text-sm text-gray-700">Статус</label>
                <select name="status" id="status" class="w-full border rounded px-3 py-2">
                    <option value="заплановано" @selected($appointment->status === 'заплановано')>📅 Заплановано</option>
                    <option value="завершено" @selected($appointment->status === 'завершено')>✅ Завершено</option>
                    <option value="скасовано" @selected($appointment->status === 'скасовано')>❌ Скасовано</option>
                </select>
            </div>

            <div class="flex justify-between items-center">
                <x-primary-button>💾 Зберегти</x-primary-button>
                <a href="{{ route('appointments.index') }}" class="text-blue-600 hover:underline">⬅ Назад</a>
            </div>
        </form>
    </div>
</x-app-layout>
