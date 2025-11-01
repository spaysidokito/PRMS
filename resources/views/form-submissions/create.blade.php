<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit Completed Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <div class="border-b pb-4">
                        <h3 class="text-2xl font-bold text-gray-900">Submit Your Completed Form</h3>
                        <p class="mt-2 text-gray-600">Upload your signed and completed form for review</p>
                    </div>

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

                    <form method="POST" action="{{ route('form-submissions.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label for="form_type" class="block text-sm font-medium text-gray-700">Form Type <span class="text-red-500">*</span></label>
                                <select name="form_type" id="form_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">Select Form Type</option>
                                    <option value="soa" {{ old('form_type') == 'soa' ? 'selected' : '' }}>Student Organization & Activities (SOA)</option>
                                    <option value="gtc" {{ old('form_type') == 'gtc' ? 'selected' : '' }}>Guidance Testing Center (GTC)</option>
                                    <option value="pod" {{ old('form_type') == 'pod' ? 'selected' : '' }}>Prefect of Discipline (POD)</option>
                                </select>
                            </div>

                            <div>
                                <label for="file" class="block text-sm font-medium text-gray-700">Upload Completed Form <span class="text-red-500">*</span></label>
                                <input type="file" name="file" id="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, JPG, PNG, DOC, DOCX (Max 10MB)</p>
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes (Optional)</label>
                                <textarea name="notes" id="notes" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Add any additional information or comments...">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-start gap-4 border-t pt-4">
                            <a href="{{ route('form-submissions.my-submissions') }}"
                                class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Submit Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
