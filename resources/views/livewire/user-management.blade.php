<div>
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
        <div class="relative flex-1 sm:flex-initial">
            <input type="text"
                   wire:model.live="search"
                   placeholder="Search users..."
                   class="w-full sm:w-auto px-4 py-2 pl-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
        @if(auth()->user()->canManageUsers())
            <button wire:click="createUser" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                <i class="fas fa-plus mr-2"></i> Add New User
            </button>
        @endif
    </div>

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

    <!-- Status Filter Tabs -->
    <div class="mb-4 border-b border-gray-200 overflow-x-auto">
        <nav class="-mb-px flex space-x-4 sm:space-x-8" aria-label="Tabs">
            <button wire:click="filterByStatus('all')"
                    class="@if($statusFilter === 'all') border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200 ease-in-out">
                All Users
                <span class="@if($statusFilter === 'all') bg-blue-100 text-blue-600 @else bg-gray-100 text-gray-900 @endif ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $totalCount }}
                </span>
            </button>
            <button wire:click="filterByStatus('active')"
                    class="@if($statusFilter === 'active') border-green-500 text-green-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200 ease-in-out">
                Active
                <span class="@if($statusFilter === 'active') bg-green-100 text-green-600 @else bg-gray-100 text-gray-900 @endif ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $activeCount }}
                </span>
            </button>
            <button wire:click="filterByStatus('inactive')"
                    class="@if($statusFilter === 'inactive') border-red-500 text-red-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200 ease-in-out">
                Deactivated
                <span class="@if($statusFilter === 'inactive') bg-red-100 text-red-600 @else bg-gray-100 text-gray-900 @endif ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $inactiveCount }}
                </span>
            </button>
        </nav>
    </div>

    <!-- Desktop Table View (hidden on mobile) -->
    <div class="hidden md:block bg-white shadow-md rounded-lg overflow-hidden" wire:loading.class="opacity-50">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('name')">
                        Name
                        @if($sortField === 'name')
                            @if($sortDirection === 'asc') <i class="fas fa-sort-up"></i> @else <i class="fas fa-sort-down"></i> @endif
                        @else
                            <i class="fas fa-sort"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('email')">
                        Email
                        @if($sortField === 'email')
                            @if($sortDirection === 'asc') <i class="fas fa-sort-up"></i> @else <i class="fas fa-sort-down"></i> @endif
                        @else
                            <i class="fas fa-sort"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr wire:key="user-{{ $user->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($role->slug === 'admin') bg-purple-100 text-purple-800
                                        @elseif($role->slug === 'faculty-staff') bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800
                                        @endif">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if(auth()->user()->canEdit())
                                <button wire:click="editUser({{ $user->id }})" class="text-yellow-600 hover:text-yellow-900 mr-2 inline-flex items-center px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-md hover:bg-yellow-600">Edit</button>
                            @endif
                            @if(auth()->user()->canManageUsers() && $user->id !== auth()->id())
                                @if($user->is_active)
                                    <button wire:click="confirmUserToggle({{ $user->id }}, 'deactivate')" class="text-red-600 hover:text-red-900 inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600">Deactivate</button>
                                @else
                                    <button wire:click="confirmUserToggle({{ $user->id }}, 'activate')" class="text-green-600 hover:text-green-900 inline-flex items-center px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-md hover:bg-green-600">Activate</button>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View (visible on mobile only) -->
    <div class="md:hidden space-y-4" wire:loading.class="opacity-50">
        @forelse ($users as $user)
            <div class="bg-white shadow-md rounded-lg overflow-hidden" wire:key="user-mobile-{{ $user->id }}">
                <div class="p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-600 break-all">{{ $user->email }}</p>
                        </div>
                        @if($user->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">
                                Inactive
                            </span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <div class="text-sm text-gray-600 mb-1">Role:</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($user->roles as $role)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($role->slug === 'admin') bg-purple-100 text-purple-800
                                    @elseif($role->slug === 'faculty-staff') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2">
                        @if(auth()->user()->canEdit())
                            <button wire:click="editUser({{ $user->id }})" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-yellow-500 text-white text-sm font-semibold rounded-md hover:bg-yellow-600">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </button>
                        @endif
                        @if(auth()->user()->canManageUsers() && $user->id !== auth()->id())
                            @if($user->is_active)
                                <button wire:click="confirmUserToggle({{ $user->id }}, 'deactivate')" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-red-500 text-white text-sm font-semibold rounded-md hover:bg-red-600">
                                    <i class="fas fa-ban mr-2"></i> Deactivate
                                </button>
                            @else
                                <button wire:click="confirmUserToggle({{ $user->id }}, 'activate')" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-green-500 text-white text-sm font-semibold rounded-md hover:bg-green-600">
                                    <i class="fas fa-check mr-2"></i> Activate
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white shadow-md rounded-lg p-6 text-center text-gray-500">
                No users found.
            </div>
        @endforelse
    </div>

    <div class="mt-4" wire:loading.class="opacity-50">
        {{ $users->links() }}
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="fixed top-0 left-0 right-0 z-50">
        <div class="bg-blue-500 h-1">
            <div class="bg-blue-700 h-1 animate-pulse"></div>
        </div>
    </div>

    <!-- User Form Modal -->
    <x-dialog-modal wire:model.live="showUserModal">
        <x-slot name="title">
            {{ $isEditing ? 'Edit User' : 'Create User' }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" type="email" class="mt-1 block w-full" wire:model="email" />
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-label for="role" value="{{ __('Role') }}" />
                    <select id="role" wire:model="selectedRole" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select a role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('selectedRole') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" type="password" class="mt-1 block w-full" wire:model="password" />
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model="password_confirmation" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="resetForm" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-3" wire:click="saveUser" wire:loading.attr="disabled">
                {{ $isEditing ? __('Update') : __('Create') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Toggle User Status Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingUserToggle">
        <x-slot name="title">
            {{ $toggleAction === 'activate' ? __('Activate User') : __('Deactivate User') }}
        </x-slot>

        <x-slot name="content">
            @if($toggleAction === 'activate')
                {{ __('Are you sure you want to activate this user? They will be able to log in again.') }}
            @else
                {{ __('Are you sure you want to deactivate this user? They will not be able to log in until reactivated.') }}
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingUserToggle', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            @if($toggleAction === 'activate')
                <x-button class="ml-3 bg-green-600 hover:bg-green-700" wire:click="toggleUserStatus" wire:loading.attr="disabled">
                    {{ __('Activate User') }}
                </x-button>
            @else
                <x-danger-button class="ml-3" wire:click="toggleUserStatus" wire:loading.attr="disabled">
                    {{ __('Deactivate User') }}
                </x-danger-button>
            @endif
        </x-slot>
    </x-dialog-modal>
</div>
