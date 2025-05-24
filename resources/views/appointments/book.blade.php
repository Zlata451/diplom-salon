<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            📝 Запис на прийом
        </h2>
    </x-slot>

    <div class="py-8 px-4 max-w-xl mx-auto">

        {{-- Повідомлення --}}
        @if (session('error'))
            <div class="mb-4 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

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

            {{-- Послуга --}}
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

            {{-- Майстер --}}
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

            {{-- Графік --}}
            <div id="schedule-box" class="mb-4 hidden border rounded p-3 bg-gray-50 text-sm text-gray-700">
                <strong>Графік роботи майстра:</strong>
                <ul id="schedule-list" class="list-disc list-inside mt-1"></ul>
            </div>

            {{-- Зайняті години --}}
            <div id="booked-times-box" class="mb-4 hidden border rounded p-3 bg-red-50 text-sm text-red-700">
                <strong>Зайняті години:</strong>
                <div id="booked-times-list" class="mt-1"></div>
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

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const masterSelect = document.getElementById('master_id');
        const serviceSelect = document.getElementById('service_id');
        const dateInput = document.getElementById('date');
        const timeInput = document.getElementById('time');
        const scheduleBox = document.getElementById('schedule-box');
        const scheduleList = document.getElementById('schedule-list');
        const bookedBox = document.getElementById('booked-times-box');
        const bookedList = document.getElementById('booked-times-list');

        async function loadSchedule() {
            const masterId = masterSelect?.value;
            if (!masterId) return;

            try {
                const res = await axios.get(`/api/masters/${masterId}/schedule`);
                scheduleList.innerHTML = '';
                res.data.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = `${item.day}: ${item.from} – ${item.to}`;
                    scheduleList.appendChild(li);
                });
                scheduleBox.classList.remove('hidden');
            } catch {
                scheduleBox.classList.add('hidden');
                scheduleList.innerHTML = '';
            }
        }

        async function loadBookedTimes() {
            const masterId = masterSelect?.value;
            const date = dateInput?.value;
            if (!masterId || !date) {
                bookedBox.classList.add('hidden');
                bookedList.innerHTML = '';
                return;
            }

            try {
                const res = await axios.get(`/api/masters/${masterId}/booked-times`, { params: { date } });
                if (res.data.length === 0) {
                    bookedBox.classList.add('hidden');
                    bookedList.innerHTML = '';
                    return;
                }

                bookedList.innerHTML = res.data.map(t => `• ${t}`).join('<br>');
                bookedBox.classList.remove('hidden');
            } catch {
                bookedBox.classList.add('hidden');
                bookedList.innerHTML = '';
            }
        }

        async function fetchAvailableTimes() {
            const date = dateInput.value;
            const masterId = masterSelect?.value;
            const serviceId = serviceSelect?.value;
            if (!date || !masterId || !serviceId) return;

            try {
                const res = await axios.get('/appointments/available-times', {
                    params: { date, master_id: masterId, service_id: serviceId }
                });

                const times = res.data;
                timeInput.innerHTML = '';

                if (times.length === 0) {
                    timeInput.innerHTML = '<option value="">Немає доступного часу</option>';
                } else {
                    times.forEach(time => {
                        const option = document.createElement('option');
                        option.value = time;
                        option.textContent = time;
                        timeInput.appendChild(option);
                    });
                }
            } catch {
                timeInput.innerHTML = '<option value="">Помилка завантаження часу</option>';
            }
        }

        function onChange() {
            loadSchedule();
            loadBookedTimes();
            fetchAvailableTimes();
        }

        if (masterSelect) masterSelect.addEventListener('change', onChange);
        if (serviceSelect) serviceSelect.addEventListener('change', fetchAvailableTimes);
        if (dateInput) dateInput.addEventListener('change', onChange);

        // ініціалізація
        onChange();
    </script>
</x-app-layout>
