<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('SOA - Student Organization & Activities') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 m-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 m-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- SOA Forms Content -->
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">SOA Form Templates</h3>
                        <p class="text-sm text-gray-600">Access and manage your SOA form templates. Place your .docx files in the <code class="bg-gray-100 px-2 py-1 rounded text-xs">public/forms/soa/</code> directory.</p>
                    </div>

                    <!-- Template Categories -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Organization Forms -->
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-users text-blue-600 text-lg"></i>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-lg">Organization Forms</h4>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Members & Officers Info Sheet</span>
                                        <div class="flex space-x-2">
                                            <button onclick="previewTemplate('MEMBERS_OFFICERS_INFOSHEET 2025')" class="text-gray-500 hover:text-gray-700 text-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="downloadTemplate('MEMBERS_OFFICERS_INFOSHEET 2025')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Adviser Info Sheet</span>
                                        <div class="flex space-x-2">
                                            <button onclick="previewTemplate('ADVISER_INFOSHEET')" class="text-gray-500 hover:text-gray-700 text-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="downloadTemplate('ADVISER_INFOSHEET')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Cover Sheet for Organizations</span>
                                        <div class="flex space-x-2">
                                            <button onclick="previewTemplate('COVER-SHEET-FOR-NEW-AND-OLD-ORGANIZATIONS')" class="text-gray-500 hover:text-gray-700 text-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="downloadTemplate('COVER-SHEET-FOR-NEW-AND-OLD-ORGANIZATIONS')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Forms -->
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar-check text-green-600 text-lg"></i>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-lg">Activity Forms</h4>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Calendar of Activities</span>
                                        <div class="flex space-x-2">
                                            <button onclick="previewTemplate('CALENDAR-OF-ACTIVITIES FINAL2025')" class="text-gray-500 hover:text-gray-700 text-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="downloadTemplate('CALENDAR-OF-ACTIVITIES FINAL2025')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Activity Application (On-campus)</span>
                                        <div class="flex space-x-2">
                                            <button onclick="previewTemplate('APPLI_INCAMPUS_2025')" class="text-gray-500 hover:text-gray-700 text-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="downloadTemplate('APPLI_INCAMPUS_2025')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Activity Application (Off-campus)</span>
                                        <div class="flex space-x-2">
                                            <button onclick="previewTemplate('APPLI_OFFCAMPUS_2025')" class="text-gray-500 hover:text-gray-700 text-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="downloadTemplate('APPLI_OFFCAMPUS_2025')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Documentation Forms -->
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-file-alt text-purple-600 text-lg"></i>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-lg">Documentation Forms</h4>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Waiver Form</span>
                                        <div class="flex space-x-2">
                                            <button onclick="previewTemplate('WAIVER')" class="text-gray-500 hover:text-gray-700 text-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="downloadTemplate('WAIVER')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Narrative Format</span>
                                        <div class="flex space-x-2">
                                            <button onclick="previewTemplate('FORMAT_NARRATIVE')" class="text-gray-500 hover:text-gray-700 text-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="downloadTemplate('FORMAT_NARRATIVE')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                        </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Members Certification</span>
                                        <div class="flex space-x-2">
                                            <button onclick="previewTemplate('LIST OF MEMBERS CERTIFY BY ORG ADVISER')" class="text-gray-500 hover:text-gray-700 text-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="downloadTemplate('LIST OF MEMBERS CERTIFY BY ORG ADVISER')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewTemplate(templateName) {
            // Preview template functionality - opens in new window
            const previewUrl = `{{ route('resources.soa.template.preview') }}?template=${templateName}`;
            window.open(previewUrl, '_blank', 'width=800,height=600,scrollbars=yes,resizable=yes');
        }


        function downloadTemplate(templateName) {
            // Download template functionality
            const downloadUrl = `{{ route('resources.soa.template.download') }}?template=${templateName}`;
            window.location.href = downloadUrl;
        }
    </script>
</x-app-layout>
