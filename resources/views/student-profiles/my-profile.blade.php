<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
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
                    {{-- Header --}}
                    <div class="border-b pb-4">
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
                    </div>

                    <div class="mt-6 flex items-center justify-start gap-4 border-t pt-4">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Back to Dashboard
                        </a>
                        <a href="{{ route('my-profile.edit') }}" class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Update My Info
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
