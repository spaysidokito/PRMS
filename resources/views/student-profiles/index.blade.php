<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Management') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Add Button Bar --}}
            <div class="mb-6 flex justify-end">
                <a href="{{ route('student-profiles.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                    Add New Student
                </a>
            </div>

            {{-- Flash message for operations --}}
            @if (session()->has('message'))
                <div class="mb-4 px-4 py-3 leading-normal text-green-700 bg-green-100 rounded-lg" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <div class="content-card">
                <div class="content-card-header mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Student Profiles</h3>
                </div>

                @livewire('student-profiles-table')
            </div>
        </div>
    </div>
</x-app-layout>
