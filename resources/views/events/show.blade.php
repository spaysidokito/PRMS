@php
    use Illuminate\Support\Facades\Auth;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 px-4 py-3 leading-normal text-green-700 bg-green-100 rounded-lg" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 px-4 py-3 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <div class="border-b pb-4">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h3>
                        <p class="mt-2 text-gray-600">{{ $event->description }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Start Date & Time</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $event->start_date->format('M d, Y h:i A') }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">End Date & Time</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $event->end_date->format('M d, Y h:i A') }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Venue</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $event->venue }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Type</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ ucfirst($event->type) }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Status</h4>
                            <span class="mt-1 px-3 py-1 inline-flex text-sm font-semibold rounded-full
                                {{ $event->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $event->status === 'ongoing' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $event->status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $event->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-start gap-4 border-t pt-4">
                        <a href="{{ route('events.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Back to List
                        </a>
                        @if(Auth::user()->canEdit())
                        <a href="{{ route('events.edit', $event->id) }}" class="inline-flex items-center px-6 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                            Edit Event
                        </a>
                        @endif
                        @if(Auth::user()->canDelete())
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this event?')">
                                Delete Event
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
