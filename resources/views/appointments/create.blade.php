<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Запис на послугу') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('appointments.store') }}">
                    @csrf

                    @if (auth()->user()->role === 'admin')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Клієнт</label>
                            <select name="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Оберіть клієнта</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Послуга</label>
                        <select name="service_id" id="service_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Оберіть послугу</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} ({{ $service->price }} грн)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Майстер</label>
                        <select name="master_id" id="master_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Оберіть спочатку послугу</option>
                        </select>
                    </div>

                    {{-- Графік роботи --}}
                    <div id="schedule-box" class="mb-4 hidden border rounded p-3 bg-gray-50 text-sm text-gray-700">
                        <strong>Графік роботи майстра:</strong>
                        <ul id="schedule-list" class="list-disc list-inside mt-1"></ul>
                    </div>

                    {{-- Зайняті години --}}
                    <div id="booked-times-box" class="mb-4 hidden border rounded p-3 bg-red-50 text-sm text-red-700">
                        <strong>Зайняті години:</strong>
                        <div id="booked-times-list" class="mt-1"></div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Дата</label>
                        <input type="date" name="date" id="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('date') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Час</label>
                        <input type="time" name="time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('time') }}" required>
                    </div>

                    <x-primary-button>
                        Записатись
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>

    {{-- Axios --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const serviceSelect = document.getElementById('service_id');
        const masterSelect = document.getElementById('master_id');
        const scheduleBox = document.getElementById('schedule-box');
        const scheduleList = document.getElementById('schedule-list');
        const dateInput = document.getElementById('date');
        const bookedBox = document.getElementById('booked-times-box');
        const bookedList = document.getElementById('booked-times-list');

        serviceSelect.addEventListener('change', async () => {
            const serviceId = serviceSelect.value;
            masterSelect.innerHTML = '<option>Завантаження...</option>';

            if (!serviceId) {
                masterSelect.innerHTML = '<option value="">Оберіть спочатку послугу</option>';
                return;
            }

            try {
                const response = await axios.get(`/api/services/${serviceId}/masters`);
                const masters = response.data;

                masterSelect.innerHTML = '<option value="">Оберіть майстра</option>';
                masters.forEach(master => {
                    const option = document.createElement('option');
                    option.value = master.id;
                    option.textContent = `${master.name} (${master.specialty})`;
                    masterSelect.appendChild(option);
                });
            } catch (error) {
                masterSelect.innerHTML = '<option value="">Помилка при завантаженні</option>';
            }
        });

        masterSelect.addEventListener('change', () => {
            loadSchedule();
            loadBookedTimes();
        });

        dateInput.addEventListener('change', loadBookedTimes);

        async function loadSchedule() {
            const masterId = masterSelect.value;
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
            const masterId = masterSelect.value;
            const date = dateInput.value;
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
    </script>
</x-app-layout>
