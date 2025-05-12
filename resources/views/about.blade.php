<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Про нас') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto space-y-8">

        {{-- 🔐 Кнопки редагування (лише для адміну) --}}
        @auth
            @if (auth()->user()->role === 'admin')
                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.about.edit', ['section' => 'note']) }}"
                       class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                        ✏️ Редагувати примітку
                    </a>
                    <a href="{{ route('admin.about.edit', ['section' => 'info']) }}"
                       class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        ✏️ Редагувати інформацію
                    </a>
                </div>
            @endif
        @endauth

        {{-- 🔔 Примітка про дипломний проєкт --}}
        @if ($note && $note->content)
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded shadow text-center">
                {!! nl2br(e($note->content)) !!}
            </div>
        @endif

        {{-- 🏡 Основна інформація про салон --}}
        <div class="bg-white p-6 rounded shadow text-gray-800 leading-relaxed">
            @if ($info && $info->content)
                {!! nl2br(e($info->content)) !!}
            @else
                <p class="text-gray-500 text-center">Інформацію про салон ще не додано.</p>
            @endif
        </div>

    </div>
</x-app-layout>
