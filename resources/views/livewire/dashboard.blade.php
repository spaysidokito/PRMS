<div class="fade-in">
    <!-- Statistics Grid (Faculty/Staff and Admin only) -->
    @if(auth()->user()->canEdit())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <!-- Total Students -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500">Total Students</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_students'] }}</div>
                </div>
            </div>
        </div>

        <!-- Active Students -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500">Active Students</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $stats['active_students'] }}</div>
                </div>
            </div>
        </div>

        <!-- Events -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500">Events</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_events'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics (Faculty/Staff and Admin only) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <!-- Dropped Students -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500">Dropped Students</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $stats['dropped_students'] }}</div>
                </div>
            </div>
        </div>

        <!-- Graduated Students -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4.5" />
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500">Graduated Students</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $stats['graduated_students'] }}</div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Student Statistics (Students only) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <!-- Total Events -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500">Total Events</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_events'] }}</div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500">Upcoming Events</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $upcomingEvents->count() }}</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Calendar and Events Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Calendar -->
        <div class="lg:col-span-2 bg-white overflow-hidden shadow-xl sm:rounded-lg card-hover">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Event Calendar</h2>
                    <div class="flex space-x-2">
                        <button wire:click="previousMonth" class="p-2 text-gray-600 hover:text-gray-800 btn-click">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <span class="px-4 py-2 text-sm font-medium text-gray-700">{{ $currentMonthYear }}</span>
                        <button wire:click="nextMonth" class="p-2 text-gray-600 hover:text-gray-800 btn-click">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="calendar-grid">
                    <!-- Day Headers -->
                    <div class="calendar-header">
                        <div class="calendar-day-header">Sun</div>
                        <div class="calendar-day-header">Mon</div>
                        <div class="calendar-day-header">Tue</div>
                        <div class="calendar-day-header">Wed</div>
                        <div class="calendar-day-header">Thu</div>
                        <div class="calendar-day-header">Fri</div>
                        <div class="calendar-day-header">Sat</div>
                    </div>

                    <!-- Calendar Days -->
                    <div class="calendar-days">
                        @foreach($calendarDays as $day)
                            <div class="calendar-day {{ $day['isCurrentMonth'] ? '' : 'other-month' }} {{ $day['isToday'] ? 'today' : '' }} {{ $day['hasEvents'] ? 'has-events' : '' }}"
                                 data-date="{{ $day['date'] }}"
                                 data-events="{{ $day['hasEvents'] ? $day['events']->pluck('title')->join(', ') : '' }}"
                                 @if($day['hasEvents'] && $day['events']->count() == 1)
                                     onclick="window.location.href='{{ route('events.show', $day['events']->first()->id) }}'"
                                     style="cursor: pointer;"
                                 @elseif($day['hasEvents'] && $day['events']->count() > 1)
                                     onclick="showEventsModal('{{ $day['date'] }}', {{ $day['events']->toJson() }})"
                                     style="cursor: pointer;"
                                 @endif>
                                <div class="day-number">{{ $day['day'] }}</div>
                                @if($day['hasEvents'])
                                    <div class="event-indicator">
                                        <div class="event-dot" data-event-title="{{ $day['events']->first()->title }}"></div>
                                        @if(count($day['events']) > 1)
                                            <span class="event-count">{{ count($day['events']) }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Events -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg card-hover">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Today's Events</h2>
                    <span class="text-sm text-gray-500">{{ now()->format('M d, Y') }}</span>
                </div>
                @if($todaysEvents->count() > 0)
                    <div class="space-y-3">
                        @foreach($todaysEvents as $event)
                            <div class="border-l-4 border-blue-500 pl-4 py-2 table-row-hover">
                                <div class="font-medium text-gray-900">{{ $event->title }}</div>
                                <div class="text-sm text-gray-500">{{ $event->start_date->format('g:i A') }} - {{ $event->end_date->format('g:i A') }}</div>
                                <div class="text-sm text-gray-500">{{ $event->venue }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No events today</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Events and Inactive Students Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Upcoming Events -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg card-hover">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Upcoming Events</h2>
                    <a href="{{ route('events.index') }}" class="text-blue-600 hover:text-blue-800 text-sm nav-link-hover">View All</a>
                </div>
                @if($upcomingEvents->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingEvents as $event)
                            <div class="border-b pb-4 last:border-b-0 last:pb-0 table-row-hover">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <a href="{{ route('events.show', $event->id) }}" class="text-lg font-medium text-gray-900 hover:text-blue-600">
                                            {{ $event->title }}
                                        </a>
                                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($event->description, 100) }}</p>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $event->start_date->format('M d, Y') }}
                                    </span>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $event->venue }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No upcoming events</p>
                @endif
            </div>
        </div>

        <!-- Inactive Students (Faculty/Staff and Admin only) -->
        @if(auth()->user()->canEdit())
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg card-hover">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Inactive Students</h2>
                    <a href="{{ route('student-profiles.index') }}" class="text-blue-600 hover:text-blue-800 text-sm nav-link-hover">View All</a>
                </div>
                @if($inactiveStudents->count() > 0)
                    <div class="space-y-4">
                        @foreach($inactiveStudents as $student)
                            <div class="border-b pb-4 last:border-b-0 last:pb-0 table-row-hover">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <a href="{{ route('student-profiles.show', $student->id) }}" class="text-lg font-medium text-gray-900 hover:text-blue-600">
                                            {{ $student->first_name }} {{ $student->last_name }}
                                        </a>
                                        <p class="text-sm text-gray-500 mt-1">{{ $student->student_id }}</p>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $student->course }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No inactive students</p>
                @endif
            </div>
        </div>
        @else
        <!-- Student Resources (for students only) -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg card-hover">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Quick Links</h2>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('events.index') }}" class="block p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <div class="font-medium text-gray-900">View All Events</div>
                                <div class="text-sm text-gray-500">Browse upcoming events</div>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('resources.index') }}" class="block p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div>
                                <div class="font-medium text-gray-900">Resources</div>
                                <div class="text-sm text-gray-500">Access forms and documents</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Events Modal for Multiple Events -->
    <div id="eventsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden events-modal modal-backdrop">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white modal-content">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalDate"></h3>
                    <button onclick="closeEventsModal()" class="text-gray-400 hover:text-gray-600 btn-click">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="modalEvents" class="space-y-3">
                    <!-- Events will be populated here -->
                </div>
            </div>
        </div>
    </div>
</div>
