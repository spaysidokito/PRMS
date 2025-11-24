<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 px-4 py-3 leading-normal text-green-700 bg-green-100 rounded-lg" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <div class="border-b pb-4">
                        <h3 class="text-2xl font-bold text-gray-900">New Event</h3>
                        <p class="mt-2 text-gray-600">Fill in the event information below</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-400 rounded-lg">
                            <p class="font-semibold">Please correct the following errors:</p>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('events.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('description') }}</textarea>
                                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Start Date & Time -->
                                <div class="space-y-4">
                                    <div class="border-l-4 border-blue-500 pl-4">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-3">Start Date & Time</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                                    <i class="fas fa-calendar mr-1 text-blue-500"></i>Date
                                                </label>
                                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            </div>
                                            <div>
                                                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">
                                                    <i class="fas fa-clock mr-1 text-blue-500"></i>Time
                                                </label>
                                                <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            </div>
                                        </div>
                                    </div>
                                    @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    @error('start_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- End Date & Time -->
                                <div class="space-y-4">
                                    <div class="border-l-4 border-green-500 pl-4">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-3">End Date & Time</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                                                    <i class="fas fa-calendar mr-1 text-green-500"></i>Date
                                                </label>
                                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                            </div>
                                            <div>
                                                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">
                                                    <i class="fas fa-clock mr-1 text-green-500"></i>Time
                                                </label>
                                                <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                            </div>
                                        </div>
                                    </div>
                                    @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    @error('end_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="venue" class="block text-sm font-medium text-gray-700">Venue</label>
                                <input type="text" name="venue" id="venue" value="{{ old('venue') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('venue') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                <select name="type" id="type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">Select Type</option>
                                    <option value="social" {{ old('type') === 'social' ? 'selected' : '' }}>Social</option>
                                    <option value="academic" {{ old('type') === 'academic' ? 'selected' : '' }}>Academic</option>
                                    <option value="training" {{ old('type') === 'training' ? 'selected' : '' }}>Training</option>
                                    <option value="workshop" {{ old('type') === 'workshop' ? 'selected' : '' }}>Workshop</option>
                                    <option value="seminar" {{ old('type') === 'seminar' ? 'selected' : '' }}>Seminar</option>
                                    <option value="other" {{ old('type') === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="mt-6 flex items-center justify-start gap-4 border-t pt-4">
                                <a href="{{ route('events.index') }}"
                                    class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    Create Event
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
