<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Form Submissions') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-end">
                <a href="{{ route('form-submissions.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                    Submit New Form
                </a>
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

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Submission History</h3>

                    @if($submissions->count() > 0)
                        <!-- Desktop Table View -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Form Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reviewed By</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($submissions as $submission)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $submission->form_type_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $submission->created_at->format('M d, Y g:i A') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $submission->status_badge_class }}">
                                                    {{ ucfirst($submission->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $submission->reviewer?->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('form-submissions.show', $submission->id) }}"
                                                   class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                                @if($submission->status === 'pending')
                                                    <form action="{{ route('form-submissions.destroy', $submission->id) }}"
                                                          method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="text-red-600 hover:text-red-900"
                                                                onclick="return confirm('Are you sure you want to delete this submission?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="md:hidden space-y-4">
                            @foreach ($submissions as $submission)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900">{{ $submission->form_type_name }}</div>
                                        </div>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $submission->status_badge_class }} ml-2">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </div>

                                    <div class="space-y-2 mb-3 text-sm">
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-calendar w-5 text-gray-400"></i>
                                            <span class="ml-2">{{ $submission->created_at->format('M d, Y g:i A') }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-user-check w-5 text-gray-400"></i>
                                            <span class="ml-2">{{ $submission->reviewer?->name ?? 'Not reviewed yet' }}</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <a href="{{ route('form-submissions.show', $submission->id) }}"
                                           class="flex-1 text-center px-3 py-2 bg-blue-500 text-white text-sm font-semibold rounded-md hover:bg-blue-600">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                        @if($submission->status === 'pending')
                                            <form action="{{ route('form-submissions.destroy', $submission->id) }}"
                                                  method="POST" class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="w-full px-3 py-2 bg-red-500 text-white text-sm font-semibold rounded-md hover:bg-red-600"
                                                        onclick="return confirm('Are you sure you want to delete this submission?')">
                                                    <i class="fas fa-trash mr-1"></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $submissions->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-2 text-gray-500">No submissions yet</p>
                            <a href="{{ route('form-submissions.create') }}"
                               class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Submit Your First Form
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
