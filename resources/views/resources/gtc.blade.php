<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('GTC - Guidance Testing Center') }}
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

                <!-- GTC Forms Content -->
                <div class="p-6">

                    <!-- Template Categories -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Testing & Application Forms -->
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-clipboard-check text-blue-600 text-lg"></i>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-lg">Testing & Application Forms</h4>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Application for SACLI Entrance Exam</span>
                                        <div class="flex space-x-2">
                                            <button onclick="downloadTemplate('Application for SACLI Entrance Exam')" class="resource-btn" style="max-width: 120px; padding: 8px 12px; font-size: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Certificate of Good Moral Request Form</span>
                                        <div class="flex space-x-2">
                                            <button onclick="downloadTemplate('Certificate of Good Moral Request Form')" class="resource-btn" style="max-width: 120px; padding: 8px 12px; font-size: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Instructor's Referral Form</span>
                                        <div class="flex space-x-2">
                                            <button onclick="downloadTemplate('INSTRUCTOR\'S REFERRAL FORM')" class="resource-btn" style="max-width: 120px; padding: 8px 12px; font-size: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                </div>
                    </div>

                            <!-- Counseling Forms -->
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-user-friends text-green-600 text-lg"></i>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-lg">Counseling Forms</h4>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Counseling Call Slip</span>
                                        <div class="flex space-x-2">
                                            <button onclick="downloadTemplate('COUNSELING CALL SLIP')" class="resource-btn" style="max-width: 120px; padding: 8px 12px; font-size: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Counseling Appointment QR</span>
                                        <div class="flex space-x-2">
                                            <button onclick="downloadTemplate('counseling appointment qr')" class="resource-btn" style="max-width: 120px; padding: 8px 12px; font-size: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">GTC Exit Interview Form for Graduating Students</span>
                                        <div class="flex space-x-2">
                                            <button onclick="downloadTemplate('GTC Exit Interview Form for Graduating Students')" class="resource-btn" style="max-width: 120px; padding: 8px 12px; font-size: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                </div>
                    </div>

                            <!-- Evaluation & Assessment Forms -->
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-chart-line text-purple-600 text-lg"></i>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 text-lg">Evaluation & Assessment Forms</h4>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Online Student-Faculty Evaluation Tool</span>
                                        <div class="flex space-x-2">
                                            <button onclick="downloadTemplate('Online Student-Faculty Evaluation Tool')" class="resource-btn" style="max-width: 120px; padding: 8px 12px; font-size: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">GTC After Activity Evaluation Tool</span>
                                        <div class="flex space-x-2">
                                            <button onclick="downloadTemplate('GTC After activity evaluation Tool')" class="resource-btn" style="max-width: 120px; padding: 8px 12px; font-size: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                        </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Satisfaction Evaluation Survey on SACLI Guidance Services</span>
                                        <div class="flex space-x-2">
                                            <button onclick="downloadTemplate('SATISFACTION EVALUATION SURVEY ON SACLI GUIDANCE SERVICES booklet style')" class="resource-btn" style="max-width: 120px; padding: 8px 12px; font-size: 12px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
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


        function downloadTemplate(templateName) {
            // Download template functionality
            const downloadUrl = `{{ route('resources.gtc.template.download') }}?template=${templateName}`;
            window.location.href = downloadUrl;
        }
    </script>
</x-app-layout>
