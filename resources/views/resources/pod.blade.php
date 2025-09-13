<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('POD - Prefect of Discipline') }}
            </h2>

        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('resources.pod.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Prefect of Discipline Form</h3>
                        <p class="text-sm text-gray-600">This form is for managing discipline-related activities and information.</p>
                    </div>

                    <!-- Form content will be added here when forms are provided -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-600 text-center py-8">
                            <i class="fas fa-gavel text-4xl text-gray-400 mb-4 block"></i>
                            Form content will be displayed here when the actual form is provided.
                        </p>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <button onclick="window.print()" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg flex items-center">
                                <i class="fas fa-print mr-2"></i>
                                Print
                            </button>
                            <a href="{{ route('resources.pod.download') }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg flex items-center">
                                <i class="fas fa-download mr-2"></i>
                                Download
                            </a>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('resources.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                                Back to Resources
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                                Save Form
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
