<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Submission Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 px-4 py-3 leading-normal text-green-700 bg-green-100 rounded-lg" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="border-b pb-4 mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $formSubmission->form_type_name }}</h3>
                            <p class="mt-1 text-sm text-gray-500">Submitted on {{ $formSubmission->created_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>

                        {{-- File Preview --}}
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold mb-3">Submitted File</h4>
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $formSubmission->original_filename }}</p>
                                            <p class="text-xs text-gray-500">Uploaded {{ $formSubmission->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $formSubmission->file_path) }}"
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View File
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Student Notes --}}
                        @if($formSubmission->notes)
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold mb-3">Student Notes</h4>
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <p class="text-gray-700">{{ $formSubmission->notes }}</p>
                            </div>
                        </div>
                        @endif

                        {{-- Admin Notes --}}
                        @if($formSubmission->admin_notes)
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold mb-3">Administrator Notes</h4>
                            <div class="border rounded-lg p-4 bg-blue-50">
                                <p class="text-gray-700">{{ $formSubmission->admin_notes }}</p>
                            </div>
                        </div>
                        @endif

                        {{-- Status Update Form (Admin/Staff only) --}}
                        @if(Auth::user()->canEdit())
                        <div class="border-t pt-6">
                            <h4 class="text-lg font-semibold mb-3">Update Status</h4>
                            <form method="POST" action="{{ route('form-submissions.update-status', $formSubmission->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                        <select name="status" id="status" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <option value="pending" {{ $formSubmission->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $formSubmission->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ $formSubmission->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="admin_notes" class="block text-sm font-medium text-gray-700">Administrator Notes</label>
                                        <textarea name="admin_notes" id="admin_notes" rows="4"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                            placeholder="Add notes about this submission...">{{ old('admin_notes', $formSubmission->admin_notes) }}</textarea>
                                    </div>

                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                        Update Status
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <h4 class="text-lg font-semibold mb-4">Submission Information</h4>

                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <span class="mt-1 px-3 py-1 inline-flex text-sm font-semibold rounded-full {{ $formSubmission->status_badge_class }}">
                                    {{ ucfirst($formSubmission->status) }}
                                </span>
                            </div>

                            @if(Auth::user()->canEdit())
                            <div>
                                <p class="text-sm font-medium text-gray-500">Student</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $formSubmission->user->name }}</p>
                                @if($formSubmission->studentProfile)
                                    <p class="text-xs text-gray-500">{{ $formSubmission->studentProfile->student_id }}</p>
                                @endif
                            </div>
                            @endif

                            <div>
                                <p class="text-sm font-medium text-gray-500">Form Type</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $formSubmission->form_type_name }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">Submitted</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $formSubmission->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $formSubmission->created_at->format('g:i A') }}</p>
                            </div>

                            @if($formSubmission->reviewed_at)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Reviewed By</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $formSubmission->reviewer?->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ $formSubmission->reviewed_at->format('M d, Y g:i A') }}</p>
                            </div>
                            @endif
                        </div>

                        <div class="mt-6 pt-6 border-t space-y-3">
                            @if(Auth::user()->canEdit())
                                <a href="{{ route('form-submissions.print', $formSubmission->id) }}"
                                   target="_blank"
                                   class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    <i class="fas fa-print mr-2"></i>Print Submitted File
                                </a>
                            @endif

                            @if(Auth::user()->isStudent())
                                <a href="{{ route('form-submissions.my-submissions') }}"
                                   class="block w-full text-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                    Back to My Submissions
                                </a>
                            @else
                                <a href="{{ route('form-submissions.index') }}"
                                   class="block w-full text-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                    Back to All Submissions
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
