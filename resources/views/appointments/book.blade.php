<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            📝 Запис на прийом
        </h2>
    </x-slot>

    <div class="py-8 px-4 max-w-xl mx-auto">
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('appointments.store') }}" class="bg-white p-6 rounded shadow space-y-5">
            @csrf

            {{-- Вибір послуги --}}
            <div>
                <label for="service_id" class="block font-medium text-sm text-gray-700">Послуга</label>
                @if(isset($service))
                    <input type="text" value="{{ $service->name }}" disabled class="mt-1 block w-full rounded border-gray-300 bg-gray-100">
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                @else
                    <select name="service_id" id="service_id" class="mt-1 block w-full rounded border-gray-300" required>
                        <option value="">Оберіть послугу</option>
                        @foreach ($services ?? \App\Models\Service::all() as $item)
                            <option value="{{ $item->id }}" {{ old('service_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            {{-- Вибір майстра --}}
            <div>
                <label for="master_id" class="block font-medium text-sm text-gray-700">Майстер</label>
                @if(isset($master))
                    <input type="text" value="{{ $master->name }} — {{ $master->specialty }}" disabled class="mt-1 block w-full rounded border-gray-300 bg-gray-100">
                    <input type="hidden" name="master_id" value="{{ $master->id }}">
                @else
                    <select name="master_id" id="master_id" class="mt-1 block w-full rounded border-gray-300" required>
                        <option value="">Оберіть майстра</option>
                        @foreach ($masters ?? \App\Models\Master::all() as $item)
                            <option value="{{ $item->id }}" {{ old('master_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} — {{ $item->specialty }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            {{-- Дата --}}
            <div>
                <label for="date" class="block font-medium text-sm text-gray-700">Дата</label>
                <input type="date" name="date" id="date" class="mt-1 block w-full rounded border-gray-300" value="{{ old('date') }}" required>
            </div>

            {{-- Час --}}
            <div>
                <label for="time" class="block font-medium text-sm text-gray-700">Час</label>
                <input type="time" name="time" id="time" class="mt-1 block w-full rounded border-gray-300" value="{{ old('time') }}" required>
            </div>

            <div class="flex justify-end pt-4">
                <x-primary-button>
                    {{ __('Записатися') }}
                </x-primary-button>
            </div>
        </form>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dateInput = document.querySelector('#date');
        const masterSelect = document.querySelector('#master_id');
        const serviceSelect = document.querySelector('#service_id');
        const timeSelect = document.querySelector('#time');

        async function fetchAvailableTimes() {
            const date = dateInput.value;
            const masterId = masterSelect?.value;
            const serviceId = serviceSelect?.value;

            if (!date || !masterId || !serviceId) {
                timeSelect.innerHTML = '<option value="">Оберіть дату, майстра і послугу</option>';
                return;
            }

            try {
                const response = await axios.get('/appointments/available-times', {
                    params: {
                        date: date,
                        master_id: masterId,
                        service_id: serviceId
                    }
                });

                const times = response.data;
                timeSelect.innerHTML = '';

                if (times.length === 0) {
                    timeSelect.innerHTML = '<option value="">Немає доступного часу</option>';
                } else {
                    times.forEach(time => {
                        const option = document.createElement('option');
                        option.value = time;
                        option.textContent = time;
                        timeSelect.appendChild(option);
                    });
                }

            } catch (error) {
                console.error(error);
                timeSelect.innerHTML = '<option value="">Помилка завантаження часу</option>';
            }
        }

        [dateInput, masterSelect, serviceSelect].forEach(el => {
            if (el) el.addEventListener('change', fetchAvailableTimes);
        });

        // Сразу обновить, если все значения уже выбраны
        fetchAvailableTimes();
    });
</script>



</x-app-layout>