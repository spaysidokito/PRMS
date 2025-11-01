<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resource Management') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()->isStudent())
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm text-blue-700">
                            <strong>Reminder:</strong> After downloading and completing your form, don't forget to
                            <a href="{{ route('form-submissions.create') }}" class="underline font-semibold hover:text-blue-900">submit it here</a>
                            for review by the administrator.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <div class="content-card">
                @livewire('resource-management')
            </div>
        </div>
    </div>
</x-app-layout>
