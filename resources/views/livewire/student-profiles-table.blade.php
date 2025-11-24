@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="fade-in">
    <!-- Search and Filters -->
    <div class="mb-4 space-y-4">
        <!-- Search Bar -->
        <div class="relative">
            <input type="text"
                   wire:model.live="search"
                   placeholder="Search students..."
                   class="w-full sm:w-auto px-4 py-2 pl-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>

        <!-- Filter Dropdowns -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Department/Cluster</label>
                <select wire:model.live="departmentFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="all">All Departments</option>
                    @foreach($departments as $department)
                        <option value="{{ $department }}">{{ $department }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                <select wire:model.live="courseFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="all">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course }}">{{ $course }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Year Level</label>
                <select wire:model.live="yearFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="all">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Account Status Filter Tabs -->
    @if(Auth::user()->canManageUsers())
    <div class="mb-4 border-b border-gray-200 overflow-x-auto scrollbar-hide relative">
        <nav class="-mb-px flex space-x-6 min-w-max px-2" aria-label="Tabs">
            <button wire:click="filterByAccountStatus('all')"
                    class="@if($accountStatusFilter === 'all') border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-4 px-3 border-b-2 font-medium text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                All Accounts
                <span class="@if($accountStatusFilter === 'all') bg-blue-100 text-blue-600 @else bg-gray-100 text-gray-900 @endif ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $totalCount }}
                </span>
            </button>
            <button wire:click="filterByAccountStatus('active')"
                    class="@if($accountStatusFilter === 'active') border-green-500 text-green-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-4 px-3 border-b-2 font-medium text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                Active Accounts
                <span class="@if($accountStatusFilter === 'active') bg-green-100 text-green-600 @else bg-gray-100 text-gray-900 @endif ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $activeCount }}
                </span>
            </button>
            <button wire:click="filterByAccountStatus('inactive')"
                    class="@if($accountStatusFilter === 'inactive') border-red-500 text-red-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-4 px-3 border-b-2 font-medium text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                Deactivated Accounts
                <span class="@if($accountStatusFilter === 'inactive') bg-red-100 text-red-600 @else bg-gray-100 text-gray-900 @endif ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $inactiveCount }}
                </span>
            </button>
        </nav>
    </div>

    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        /* Fade indicator on right side */
        .scrollbar-hide::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 60px;
            background: linear-gradient(to right, transparent, white);
            pointer-events: none;
        }
    </style>
    @endif

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="hidden md:block bg-white shadow-md rounded-lg overflow-hidden" wire:loading.class="opacity-50">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Account</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($students as $student)
                    <tr wire:key="student-table-{{ $student->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $student->student_id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $student->getFullNameAttribute() }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $student->course }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $student->department_cluster }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClass = '';
                                switch (strtolower($student->status)) {
                                    case 'active':
                                        $statusClass = 'bg-green-100 text-green-800';
                                        break;
                                    case 'dropped':
                                        $statusClass = 'bg-red-100 text-red-800';
                                        break;
                                    case 'graduated':
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                        break;
                                    default:
                                        $statusClass = 'bg-gray-100 text-gray-800';
                                }
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($student->user)
                                @if($student->user->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    No Account
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('student-profiles.show', $student->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600">View</a>
                                @if(Auth::user()->canEdit())
                                    <a href="{{ route('student-profiles.edit', $student->id) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-md hover:bg-yellow-600">Edit</a>
                                @endif
                                @if(Auth::user()->canManageUsers() && $student->user)
                                    @if($student->user->is_active)
                                        <button wire:click="confirmToggle({{ $student->id }}, 'deactivate')" class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600">Deactivate</button>
                                    @else
                                        <button wire:click="confirmToggle({{ $student->id }}, 'activate')" class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-md hover:bg-green-600">Activate</button>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-sm text-gray-500 text-center">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View (visible on mobile only) -->
    <div class="md:hidden space-y-4" wire:loading.class="opacity-50">
        @forelse ($students as $student)
            <div wire:key="student-mobile-{{ $student->id }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                <!-- Student Info -->
                <div class="p-4">
                    <!-- Profile Picture Placeholder -->
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-blue-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 truncate">{{ $student->getFullNameAttribute() }}</h3>
                            <p class="text-xs text-gray-500">{{ $student->student_id }}</p>
                        </div>
                    </div>

                    <!-- Student Details -->
                    <div class="space-y-2 mb-3">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-graduation-cap text-gray-400 mr-2"></i>
                            <span class="font-medium">{{ $student->course }}</span>
                        </p>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-building text-gray-400 mr-2"></i>
                            {{ $student->department_cluster }}
                        </p>
                    </div>

                    <!-- Status Badges -->
                    <div class="flex flex-wrap gap-2 mb-3">
                        @php
                            $statusClass = '';
                            switch (strtolower($student->status)) {
                                case 'active':
                                    $statusClass = 'bg-green-100 text-green-800';
                                    break;
                                case 'dropped':
                                    $statusClass = 'bg-red-100 text-red-800';
                                    break;
                                case 'graduated':
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                    break;
                                default:
                                    $statusClass = 'bg-gray-100 text-gray-800';
                            }
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                            {{ ucfirst($student->status) }}
                        </span>

                        @if($student->user)
                            @if($student->user->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>Inactive
                                </span>
                            @endif
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                No Account
                            </span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('student-profiles.show', $student->id) }}" class="flex-1 text-center px-3 py-2 bg-blue-500 text-white text-sm font-semibold rounded-md hover:bg-blue-600 transition">
                            <i class="fas fa-eye mr-1"></i>View
                        </a>
                        @if(Auth::user()->canEdit())
                        <a href="{{ route('student-profiles.edit', $student->id) }}" class="flex-1 text-center px-3 py-2 bg-yellow-500 text-white text-sm font-semibold rounded-md hover:bg-yellow-600 transition">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        @endif
                        @if(Auth::user()->canManageUsers() && $student->user)
                            @if($student->user->is_active)
                                <button wire:click="confirmToggle({{ $student->id }}, 'deactivate')" class="flex-1 px-3 py-2 bg-red-500 text-white text-sm font-semibold rounded-md hover:bg-red-600 transition">
                                    <i class="fas fa-ban mr-1"></i>Deactivate
                                </button>
                            @else
                                <button wire:click="confirmToggle({{ $student->id }}, 'activate')" class="flex-1 px-3 py-2 bg-green-500 text-white text-sm font-semibold rounded-md hover:bg-green-600 transition">
                                    <i class="fas fa-check mr-1"></i>Activate
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-user-graduate text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">No students found.</p>
                <p class="text-gray-400 text-sm mt-2">Try adjusting your search or filters.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4" wire:loading.class="opacity-50">
        {{ $students->links() }}
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="fixed top-0 left-0 right-0 z-50">
        <div class="bg-blue-500 h-1">
            <div class="bg-blue-700 h-1 animate-pulse"></div>
        </div>
    </div>

    <!-- Toggle Account Status Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingToggle" class="scale-in">
        <x-slot name="title">
            {{ $toggleAction === 'activate' ? __('Activate Student Account') : __('Deactivate Student Account') }}
        </x-slot>

        <x-slot name="content">
            @if($toggleAction === 'activate')
                {{ __('Are you sure you want to activate this student account? They will be able to log in again.') }}
            @else
                {{ __('Are you sure you want to deactivate this student account? They will not be able to log in until reactivated.') }}
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingToggle', false)" wire:loading.attr="disabled" class="btn-click">
                {{ __('Cancel') }}
            </x-secondary-button>

            @if($toggleAction === 'activate')
                <x-button class="ml-3 bg-green-600 hover:bg-green-700 btn-click" wire:click="toggleStudentStatus" wire:loading.attr="disabled">
                    {{ __('Activate Account') }}
                </x-button>
            @else
                <x-danger-button class="ml-3 btn-click" wire:click="toggleStudentStatus" wire:loading.attr="disabled">
                    {{ __('Deactivate Account') }}
                </x-danger-button>
            @endif
        </x-slot>
    </x-dialog-modal>
</div>
