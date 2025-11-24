<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Management') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash message for operations --}}
            @if (session()->has('message'))
                <div class="mb-4 px-4 py-3 leading-normal text-green-700 bg-green-100 rounded-lg" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <div class="content-card">
                <div class="content-card-header mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Events</h3>
                </div>

                @livewire('event-management')
            </div>
        </div>
    </div>
</x-app-layout>
