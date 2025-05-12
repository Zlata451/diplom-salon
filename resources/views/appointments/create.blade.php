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

                <form method="POST" action="{{ route('appointments.store') }}">
                    @csrf

                    {{-- Послуга --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Послуга</label>
                        <select name="service_id" id="service_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Оберіть послугу</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }} ({{ $service->price }} грн)</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Майстер --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Майстер</label>
                        <select name="master_id" id="master_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Оберіть спочатку послугу</option>
                        </select>
                    </div>

                    {{-- Дата --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Дата</label>
                        <input type="date" name="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    {{-- Час --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Час</label>
                        <input type="time" name="time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
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

                if (masters.length === 0) {
                    masterSelect.innerHTML = '<option value="">Немає майстрів для цієї послуги</option>';
                    return;
                }

                masterSelect.innerHTML = '<option value="">Оберіть майстра</option>';
                masters.forEach(master => {
                    const option = document.createElement('option');
                    option.value = master.id;
                    option.textContent = `${master.name} (${master.specialty})`;
                    masterSelect.appendChild(option);
                });

            } catch (error) {
                console.error('Помилка при завантаженні майстрів:', error);
                masterSelect.innerHTML = '<option value="">Помилка при завантаженні</option>';
            }
        });
    </script>
</x-app-layout>
