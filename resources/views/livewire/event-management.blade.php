@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="fade-in">
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="mb-6 flex justify-between items-center">
        <div class="relative">
            <input type="text"
                   wire:model.live="search"
                   placeholder="Search events..."
                   class="px-4 py-2 pl-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                   style="width: 300px;">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
        @if(auth()->user()->canEdit())
        <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition btn-click">
            <i class="fas fa-plus mr-2"></i> Add New Event
        </a>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="mb-4 px-4 py-3 leading-normal text-green-700 bg-green-100 rounded-lg fade-in" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden card-hover">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('title')">
                        Title
                        @if($sortField === 'title')
                            @if($sortDirection === 'asc') <i class="fas fa-sort-up"></i> @else <i class="fas fa-sort-down"></i> @endif
                        @else
                            <i class="fas fa-sort"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('start_date')">
                        Start Date
                        @if($sortField === 'start_date')
                            @if($sortDirection === 'asc') <i class="fas fa-sort-up"></i> @else <i class="fas fa-sort-down"></i> @endif
                        @else
                            <i class="fas fa-sort"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Venue</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($events as $event)
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ Str::limit($event->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $event->start_date->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $event->end_date->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $event->venue }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ ucfirst($event->type) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($event->status === 'upcoming') bg-green-100 text-green-800
                                @elseif($event->status === 'ongoing') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('events.show', $event) }}" class="text-indigo-600 hover:text-indigo-900 mr-2 inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600 btn-click">View</a>
                            @if(auth()->user()->canEdit())
                            <a href="{{ route('events.edit', $event) }}" class="text-yellow-600 hover:text-yellow-900 mr-2 inline-flex items-center px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-md hover:bg-yellow-600 btn-click">Edit</a>
                            @if(auth()->user()->canDelete())
                            <button wire:click="confirmEventDeletion({{ $event->id }})" class="text-red-600 hover:text-red-900 inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600 btn-click">Delete</button>
                            @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No events found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $events->links() }}
    </div>

    @if(auth()->user()->canEdit())
    <!-- Delete Event Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingEventDeletion" class="scale-in">
        <x-slot name="title">
            {{ __('Delete Event') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this event? This action cannot be undone.') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingEventDeletion', false)" wire:loading.attr="disabled" class="btn-click">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3 btn-click" wire:click="deleteEvent" wire:loading.attr="disabled">
                {{ __('Delete Event') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
    @endif
</div>
