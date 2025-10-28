@php
    use Illuminate\Support\Facades\Auth;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Details') }}
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
                    {{-- Header with Profile Picture --}}
                    <div class="border-b pb-4">
                        <div class="flex items-center space-x-4">
                            <div class="shrink-0">
                                <img class="h-[18px] w-[18px] object-cover rounded-full border border-blue-200"
                                     src="{{ $studentProfile->profile_picture_url }}"
                                     alt="{{ $studentProfile->full_name }}">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $studentProfile->getFullNameAttribute() }}</h3>
                                <p class="mt-1 text-base text-gray-600">Student ID: {{ $studentProfile->student_id }}</p>
                                <div class="mt-3">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                                        @if($studentProfile->status === 'active') bg-green-100 text-green-800
                                        @elseif($studentProfile->status === 'inactive') bg-red-100 text-red-800
                                        @elseif($studentProfile->status === 'graduated') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($studentProfile->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">First Name</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $studentProfile->first_name }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Last Name</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $studentProfile->last_name }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Middle Name</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $studentProfile->middle_name ?: 'N/A' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Birth Date</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $studentProfile->birth_date->format('F d, Y') }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Gender</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ ucfirst($studentProfile->gender) }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Contact Number</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $studentProfile->contact_number }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Email</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $studentProfile->email }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Address</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $studentProfile->address }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Course</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $studentProfile->course }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Year Level</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $studentProfile->year_level }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Section</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $studentProfile->section }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Department/Cluster</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $studentProfile->department_cluster }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Status</h4>
                            <span class="mt-1 px-3 py-1 inline-flex text-sm font-semibold rounded-full
                                {{ $studentProfile->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $studentProfile->status === 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $studentProfile->status === 'graduated' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $studentProfile->status === 'dropped' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($studentProfile->status) }}
                            </span>
                        </div>
                    </div>

                    @if($studentProfile->emergency_contact)
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h4 class="text-lg font-semibold mb-2">Emergency Contact Information</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <pre class="whitespace-pre-wrap text-sm text-gray-700">{{ json_encode($studentProfile->emergency_contact, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                    @endif

                    @if($studentProfile->medical_information)
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h4 class="text-lg font-semibold mb-2">Medical Information</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <pre class="whitespace-pre-wrap text-sm text-gray-700">{{ json_encode($studentProfile->medical_information, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                    @endif

                    <div class="mt-6 flex items-center justify-start gap-4 border-t pt-4">
                        <a href="{{ route('student-profiles.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Back to List
                        </a>
                        @if(Auth::user()->canEdit())
                        <a href="{{ route('student-profiles.edit', $studentProfile->id) }}" class="inline-flex items-center px-6 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                            Edit Profile
                        </a>
                        @endif
                        @if(Auth::user()->canDelete())
                        <form action="{{ route('student-profiles.destroy', $studentProfile->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this student profile?')">
                                Delete Profile
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
