<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('POD - Prefect of Discipline') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Manage Forms Button -->
            @if(auth()->user()->canEdit())
            <div class="mb-6 flex justify-end">
                <a href="{{ route('resources.manage-pod') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow-sm hover:shadow-md transition-all duration-200 flex items-center uppercase text-sm">
                    <i class="fas fa-cog mr-2"></i>Manage Forms
                </a>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    @if($forms->isEmpty())
                        <div class="text-center py-12">
                            <i class="fas fa-folder-open text-gray-400 text-6xl mb-4"></i>
                            <p class="text-gray-600">No forms available at the moment.</p>
                        </div>
                    @else
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-gavel text-purple-600 text-lg"></i>
                                </div>
                                <h4 class="font-semibold text-gray-900 text-lg">POD Forms</h4>
                            </div>
                            <div class="space-y-3">
                                @foreach($forms as $form)
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm text-gray-600">{{ $form->name }}</span>
                                    <div class="flex space-x-2">
                                        <button onclick="downloadTemplate('{{ $form->template_filename }}')" class="resource-btn" style="max-width: 120px; padding: 8px 12px; font-size: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                            <i class="fas fa-download mr-1"></i>Download
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadTemplate(templateName) {
            // Download template functionality
            const downloadUrl = `{{ route('resources.pod.download') }}?template=${templateName}`;
            window.location.href = downloadUrl;
        }
    </script>
</x-app-layout>
