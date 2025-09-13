<x-app-layout>
    <x-slot name="header">
        {{-- The header title is now managed in app.blade.php, but we can still set the text here --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Welcome Message --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
        </div>
                    <div class="ml-4">
                        <p class="text-lg font-medium text-gray-900">Hello, {{ Auth::user()->name }}! Welcome to PRIMOSA!</p>
                </div>
            </div>
        </div>

            {{-- Stats Grid using Livewire component --}}
            @livewire('dashboard')
        </div>
    </div>
</x-app-layout>
