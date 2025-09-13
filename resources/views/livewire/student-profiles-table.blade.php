@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="fade-in">
    <div class="mb-4">
        <div class="relative">
            <input type="text"
                   wire:model.live="search"
                   placeholder="Search students..."
                   class="px-4 py-2 pl-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                   style="width: 300px;">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
    </div>

    {{-- Search input and Add button will be moved to the parent Blade view --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden card-hover">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('student_id')">
                        Student ID
                        @if($sortField === 'student_id')
                            @if($sortDirection === 'asc') <i class="fas fa-sort-up"></i> @else <i class="fas fa-sort-down"></i> @endif
                        @else
                            <i class="fas fa-sort"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('last_name')">
                        Name
                        @if($sortField === 'last_name')
                            @if($sortDirection === 'asc') <i class="fas fa-sort-up"></i> @else <i class="fas fa-sort-down"></i> @endif
                        @else
                            <i class="fas fa-sort"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('course')">
                        Course
                        @if($sortField === 'course')
                            @if($sortDirection === 'asc') <i class="fas fa-sort-up"></i> @else <i class="fas fa-sort-down"></i> @endif
                        @else
                            <i class="fas fa-sort"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('department_cluster')">
                        Department/Cluster
                        @if($sortField === 'department_cluster')
                            @if($sortDirection === 'asc') <i class="fas fa-sort-up"></i> @else <i class="fas fa-sort-down"></i> @endif
                        @else
                            <i class="fas fa-sort"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('status')">
                        Status
                        @if($sortField === 'status')
                            @if($sortDirection === 'asc') <i class="fas fa-sort-up"></i> @else <i class="fas fa-sort-down"></i> @endif
                        @else
                            <i class="fas fa-sort"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($students as $student)
                    <tr class="table-row-hover">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->student_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->getFullNameAttribute() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->course }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->department_cluster }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('student-profiles.show', $student->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2 inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600 btn-click">View</a>
                            @if(Auth::user()->canEdit())
                            <a href="{{ route('student-profiles.edit', $student->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2 inline-flex items-center px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-md hover:bg-yellow-600 btn-click">Edit</a>
                            @endif
                            @if(Auth::user()->canDelete())
                            <button wire:click="confirmDelete({{ $student->id }})" class="text-red-600 hover:text-red-900 inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600 btn-click">Delete</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $students->links() }}
    </div>

    <!-- Delete Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingDelete" class="scale-in">
        <x-slot name="title">
            {{ __('Delete Student Profile') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this student profile? This action cannot be undone.') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="cancelDelete" wire:loading.attr="disabled" class="btn-click">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3 btn-click" wire:click="deleteStudent" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
