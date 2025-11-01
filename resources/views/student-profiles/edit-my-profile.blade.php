<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update My Information') }}
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
                        <h3 class="text-2xl font-bold text-gray-900">Update Your Information</h3>
                        <p class="mt-2 text-gray-600">You can update your contact information below</p>
                    </div>

                    {{-- Display validation errors --}}
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

                    <form method="POST" action="{{ route('my-profile.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- Read-only fields --}}
                        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Basic Information (Read-Only)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Student ID</label>
                                    <p class="mt-1 text-gray-900">{{ $studentProfile->student_id }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Full Name</label>
                                    <p class="mt-1 text-gray-900">{{ $studentProfile->getFullNameAttribute() }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Course</label>
                                    <p class="mt-1 text-gray-900">{{ $studentProfile->course }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Year Level</label>
                                    <p class="mt-1 text-gray-900">{{ $studentProfile->year_level }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Editable fields --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $studentProfile->email) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <p class="mt-1 text-xs text-gray-500">This will also update your login email</p>
                            </div>

                            <div>
                                <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number <span class="text-red-500">*</span></label>
                                <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $studentProfile->contact_number) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Address <span class="text-red-500">*</span></label>
                                <input type="text" name="address" id="address" value="{{ old('address', $studentProfile->address) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-start gap-4 border-t pt-4">
                            <a href="{{ route('my-profile') }}"
                                class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
