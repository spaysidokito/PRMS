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
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Open in New Tab
                            </a>
                            <a href="{{ route('resources.soa.template.download', ['template' => $templateName]) }}"
                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-download mr-2"></i>
                                Download
                            </a>
                            <button onclick="copyFileUrl()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-copy mr-2"></i>
                                Copy URL
                            </button>
                        </div>
                    </div>

                    <!-- Document Preview -->
                    <div class="border border-gray-300 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-2 border-b border-gray-300">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Document Preview</span>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-gray-500">Powered by Microsoft Office Online</span>
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Office Online Viewer -->
                        <div class="relative" style="height: 80vh;">
                            <iframe
                                src="{{ $officeViewerUrl }}"
                                width="100%"
                                height="100%"
                                frameborder="0"
                                class="border-0"
                                id="officeViewer">
                            </iframe>

                            <!-- Loading indicator -->
                            <div id="loadingIndicator" class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                                    <p class="text-gray-600">Loading document preview...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alternative viewing options -->
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <h3 class="text-sm font-medium text-yellow-800 mb-2">Having trouble viewing the document?</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ $originalFileUrl }}" target="_blank"
                               class="inline-flex items-center text-sm text-yellow-700 hover:text-yellow-900 underline">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                Open in New Tab
                            </a>
                            <a href="{{ route('resources.soa.template.download', ['template' => $templateName]) }}"
                               class="inline-flex items-center text-sm text-yellow-700 hover:text-yellow-900 underline">
                                <i class="fas fa-download mr-1"></i>
                                Download File
                            </a>
                            <button onclick="copyFileUrl()"
                                    class="inline-flex items-center text-sm text-yellow-700 hover:text-yellow-900 underline">
                                <i class="fas fa-copy mr-1"></i>
                                Copy File URL
                            </button>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">Preview Instructions:</h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• The document is displayed using Microsoft Office Online viewer</li>
                            <li>• You can scroll, zoom, and navigate through the document</li>
                            <li>• This is a read-only preview of the original DOCX file</li>
                            <li>• Use the download button to get a copy of the file</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hide loading indicator when iframe loads
        document.getElementById('officeViewer').onload = function() {
            document.getElementById('loadingIndicator').style.display = 'none';
        };

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

        // Handle iframe load errors
        document.getElementById('officeViewer').onerror = function() {
            document.getElementById('loadingIndicator').innerHTML = `
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                    <p class="text-gray-600 mb-4">Unable to load document preview</p>
                    <div class="space-x-3">
                        <a href="{{ $originalFileUrl }}" target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            Open in New Tab
                        </a>
                        <a href="{{ route('resources.soa.template.download', ['template' => $templateName]) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <i class="fas fa-download mr-2"></i>
                            Download File
                        </a>
                    </div>
                </div>
            `;
        };
    </script>
</x-app-layout>
