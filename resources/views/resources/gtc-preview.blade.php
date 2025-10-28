<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Preview: ') . str_replace('_', ' ', $templateName) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header with actions -->
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ str_replace('_', ' ', $templateName) }}</h1>
                            <p class="text-gray-600 mt-1">Preview the original document</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ $originalFileUrl }}" target="_blank"
                               class="resource-btn" style="max-width: 160px; padding: 10px 16px; font-size: 13px;">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Open in New Tab
                            </a>
                            <a href="{{ route('resources.gtc.template.download', ['template' => $templateName]) }}"
                               class="resource-btn" style="max-width: 140px; padding: 10px 16px; font-size: 13px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                <i class="fas fa-download mr-2"></i>
                                Download
                            </a>
                            <button onclick="copyFileUrl()"
                                    class="resource-btn" style="max-width: 140px; padding: 10px 16px; font-size: 13px; background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);">
                                <i class="fas fa-copy mr-2"></i>
                                Copy URL
                            </button>
                        </div>
                    </div>

                    <!-- Document Preview -->
                    <div class="border border-gray-300 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-2 border-b border-gray-300">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Document Information</span>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-gray-500">DOCX Document</span>
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Document Info and Preview -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Document Details -->
                                <div class="space-y-4">
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <h3 class="text-lg font-semibold text-blue-900 mb-3">Document Details</h3>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-sm text-blue-700">File Name:</span>
                                                <span class="text-sm font-medium text-blue-900">{{ $templateName }}.docx</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-blue-700">File Type:</span>
                                                <span class="text-sm font-medium text-blue-900">Microsoft Word Document</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-blue-700">File Size:</span>
                                                <span class="text-sm font-medium text-blue-900">{{ number_format(filesize($templatePath) / 1024, 1) }} KB</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-blue-700">Last Modified:</span>
                                                <span class="text-sm font-medium text-blue-900">{{ date('M j, Y g:i A', filemtime($templatePath)) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <h3 class="text-lg font-semibold text-green-900 mb-3">Quick Actions</h3>
                                        <div class="space-y-3">
                                            <a href="{{ $originalFileUrl }}" target="_blank"
                                               class="w-full resource-btn flex items-center justify-center" style="max-width: none; padding: 12px 20px;">
                                                <i class="fas fa-external-link-alt mr-2"></i>
                                                Open in New Tab
                                            </a>
                                            <a href="{{ route('resources.gtc.template.download', ['template' => $templateName]) }}"
                                               class="w-full resource-btn flex items-center justify-center" style="max-width: none; padding: 12px 20px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                                <i class="fas fa-download mr-2"></i>
                                                Download Document
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Document Preview Placeholder -->
                                <div class="space-y-4">
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                                        <div class="mb-4">
                                            <i class="fas fa-file-word text-6xl text-blue-600"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Microsoft Word Document</h3>
                                        <p class="text-gray-600 mb-4">This is a DOCX file that can be opened with Microsoft Word or compatible applications.</p>

                                        <!-- File Preview Info -->
                                        <div class="bg-white border border-gray-200 rounded-lg p-4 text-left">
                                            <h4 class="font-medium text-gray-900 mb-2">Preview Options:</h4>
                                            <ul class="text-sm text-gray-600 space-y-1">
                                                <li>• Click "Open in New Tab" to view in browser</li>
                                                <li>• Click "Download Document" to save locally</li>
                                                <li>• Use Microsoft Word or LibreOffice to open</li>
                                                <li>• Compatible with Google Docs online</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Alternative Viewers -->
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <h3 class="text-lg font-semibold text-yellow-900 mb-3">Alternative Viewers</h3>
                                        <div class="space-y-2 text-sm text-yellow-800">
                                            <p>• <strong>Google Docs:</strong> Upload to Google Drive and open with Google Docs</p>
                                            <p>• <strong>Microsoft Word Online:</strong> Upload to OneDrive and open online</p>
                                            <p>• <strong>LibreOffice:</strong> Free alternative to Microsoft Word</p>
                                            <p>• <strong>Browser:</strong> Some browsers can display DOCX files directly</p>
                                        </div>
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
        // Copy file URL to clipboard
        function copyFileUrl() {
            const fileUrl = '{{ $originalFileUrl }}';
            navigator.clipboard.writeText(fileUrl).then(function() {
                showNotification('File URL copied to clipboard!', 'success');
            }, function() {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = fileUrl;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showNotification('File URL copied to clipboard!', 'success');
            });
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</x-app-layout>

