<div>
    <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row gap-3 sm:gap-0 sm:justify-between sm:items-center">
        <div class="relative w-full sm:w-auto">
            <input type="text"
                   wire:model.live="search"
                   placeholder="Search documents..."
                   class="w-full sm:w-64 md:w-80 px-4 py-2 pl-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
        <button wire:click="openUploadModal" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
            <i class="fas fa-upload mr-2"></i> <span class="hidden sm:inline">Upload Document</span><span class="sm:hidden">Upload</span>
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 px-4 py-3 leading-normal text-green-700 bg-green-100 rounded-lg" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <!-- Filter Tabs -->
    <div class="mb-4 sm:mb-6 border-b border-gray-200 overflow-x-auto scrollbar-hide relative">
        <nav class="-mb-px flex space-x-4 sm:space-x-6 md:space-x-8 min-w-max px-1" aria-label="Tabs">
            <button wire:click="filterByType('all')"
                    class="@if($filterType === 'all') border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                <span class="hidden sm:inline">All Documents</span><span class="sm:hidden">All</span>
                <span class="@if($filterType === 'all') bg-blue-100 text-blue-600 @else bg-gray-100 text-gray-900 @endif ml-2 sm:ml-3 py-0.5 px-2 sm:px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $counts->total ?? 0 }}
                </span>
            </button>
            <button wire:click="filterByType('receipt')"
                    class="@if($filterType === 'receipt') border-green-500 text-green-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                Receipts
                <span class="@if($filterType === 'receipt') bg-green-100 text-green-600 @else bg-gray-100 text-gray-900 @endif ml-2 sm:ml-3 py-0.5 px-2 sm:px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $counts->receipt ?? 0 }}
                </span>
            </button>
            <button wire:click="filterByType('permit')"
                    class="@if($filterType === 'permit') border-purple-500 text-purple-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                Permits
                <span class="@if($filterType === 'permit') bg-purple-100 text-purple-600 @else bg-gray-100 text-gray-900 @endif ml-2 sm:ml-3 py-0.5 px-2 sm:px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $counts->permit ?? 0 }}
                </span>
            </button>
            <button wire:click="filterByType('id')"
                    class="@if($filterType === 'id') border-yellow-500 text-yellow-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                IDs
                <span class="@if($filterType === 'id') bg-yellow-100 text-yellow-600 @else bg-gray-100 text-gray-900 @endif ml-2 sm:ml-3 py-0.5 px-2 sm:px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $counts->id ?? 0 }}
                </span>
            </button>
            <button wire:click="filterByType('certificate')"
                    class="@if($filterType === 'certificate') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                Certificates
                <span class="@if($filterType === 'certificate') bg-indigo-100 text-indigo-600 @else bg-gray-100 text-gray-900 @endif ml-2 sm:ml-3 py-0.5 px-2 sm:px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $counts->certificate ?? 0 }}
                </span>
            </button>
            @if(auth()->user()->canEdit())
            <button wire:click="filterByType('memo')"
                    class="@if($filterType === 'memo') border-pink-500 text-pink-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                Memos
                <span class="@if($filterType === 'memo') bg-pink-100 text-pink-600 @else bg-gray-100 text-gray-900 @endif ml-2 sm:ml-3 py-0.5 px-2 sm:px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $counts->memo ?? 0 }}
                </span>
            </button>
            <button wire:click="filterByType('report')"
                    class="@if($filterType === 'report') border-teal-500 text-teal-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                Reports
                <span class="@if($filterType === 'report') bg-teal-100 text-teal-600 @else bg-gray-100 text-gray-900 @endif ml-2 sm:ml-3 py-0.5 px-2 sm:px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $counts->report ?? 0 }}
                </span>
            </button>
            <button wire:click="filterByType('contract')"
                    class="@if($filterType === 'contract') border-orange-500 text-orange-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                Contracts
                <span class="@if($filterType === 'contract') bg-orange-100 text-orange-600 @else bg-gray-100 text-gray-900 @endif ml-2 sm:ml-3 py-0.5 px-2 sm:px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $counts->contract ?? 0 }}
                </span>
            </button>
            <button wire:click="filterByType('invoice')"
                    class="@if($filterType === 'invoice') border-cyan-500 text-cyan-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                Invoices
                <span class="@if($filterType === 'invoice') bg-cyan-100 text-cyan-600 @else bg-gray-100 text-gray-900 @endif ml-2 sm:ml-3 py-0.5 px-2 sm:px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $counts->invoice ?? 0 }}
                </span>
            </button>
            @endif
            <button wire:click="filterByType('other')"
                    class="@if($filterType === 'other') border-gray-500 text-gray-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif flex-shrink-0 py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-all duration-200 ease-in-out inline-flex items-center whitespace-nowrap">
                Other
                <span class="@if($filterType === 'other') bg-gray-200 text-gray-600 @else bg-gray-100 text-gray-900 @endif ml-2 sm:ml-3 py-0.5 px-2 sm:px-2.5 rounded-full text-xs font-medium transition-all duration-200 ease-in-out">
                    {{ $counts->other ?? 0 }}
                </span>
            </button>
        </nav>
    </div>

    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        /* Fade indicator on right side */
        .scrollbar-hide::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 60px;
            background: linear-gradient(to right, transparent, white);
            pointer-events: none;
        }
    </style>

    <!-- Documents Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4" wire:loading.class="opacity-50">
        @forelse ($documents as $document)
            <div wire:key="document-{{ $document->id }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                <!-- Document Preview -->
                <div class="h-48 bg-gray-100 flex items-center justify-center">
                    @if($document->isImage())
                        <img src="{{ Storage::url($document->file_path) }}" alt="{{ $document->title }}" class="h-full w-full object-cover">
                    @elseif($document->isPdf())
                        <i class="fas fa-file-pdf text-red-500 text-6xl"></i>
                    @else
                        <i class="fas fa-file text-gray-400 text-6xl"></i>
                    @endif
                </div>

                <!-- Document Info -->
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 truncate mb-1">{{ $document->title }}</h3>
                    <p class="text-xs text-gray-500 mb-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                            @if($document->document_type === 'receipt') bg-green-100 text-green-800
                            @elseif($document->document_type === 'permit') bg-purple-100 text-purple-800
                            @elseif($document->document_type === 'id') bg-yellow-100 text-yellow-800
                            @elseif($document->document_type === 'certificate') bg-indigo-100 text-indigo-800
                            @elseif($document->document_type === 'memo') bg-pink-100 text-pink-800
                            @elseif($document->document_type === 'report') bg-teal-100 text-teal-800
                            @elseif($document->document_type === 'contract') bg-orange-100 text-orange-800
                            @elseif($document->document_type === 'invoice') bg-cyan-100 text-cyan-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($document->document_type) }}
                        </span>
                    </p>
                    @if($document->description)
                        <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $document->description }}</p>
                    @endif
                    <p class="text-xs text-gray-400 mb-3">
                        <i class="fas fa-calendar mr-1"></i>{{ $document->created_at->format('M d, Y') }}
                        <span class="ml-2"><i class="fas fa-file mr-1"></i>{{ $document->file_size_formatted }}</span>
                    </p>

                    <!-- Actions -->
                    <div class="flex space-x-2">
                        <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="flex-1 text-center px-2 sm:px-3 py-1.5 sm:py-1 bg-blue-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600 transition active:scale-95">
                            <i class="fas fa-eye mr-1"></i><span class="hidden sm:inline">View</span>
                        </a>
                        <a href="{{ route('my-documents.download', $document->id) }}" class="flex-1 text-center px-2 sm:px-3 py-1.5 sm:py-1 bg-green-500 text-white text-xs font-semibold rounded-md hover:bg-green-600 transition active:scale-95">
                            <i class="fas fa-download mr-1"></i><span class="hidden sm:inline">Download</span>
                        </a>
                        <button wire:click="confirmDelete({{ $document->id }})" class="px-2 sm:px-3 py-1.5 sm:py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600 transition active:scale-95">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-8 sm:py-12 px-4">
                <i class="fas fa-folder-open text-gray-300 text-5xl sm:text-6xl mb-3 sm:mb-4"></i>
                <p class="text-gray-500 text-base sm:text-lg">No documents found.</p>
                <p class="text-gray-400 text-xs sm:text-sm mt-2">Upload your first document to get started!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6" wire:loading.class="opacity-50">
        {{ $documents->links() }}
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="fixed top-0 left-0 right-0 z-50">
        <div class="bg-blue-500 h-1">
            <div class="bg-blue-700 h-1 animate-pulse"></div>
        </div>
    </div>

    <!-- Upload Modal -->
    <x-dialog-modal wire:model.live="showUploadModal">
        <x-slot name="title">
            {{ __('Upload Document') }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="title" value="{{ __('Document Title') }}" />
                    <x-input id="title" type="text" class="mt-1 block w-full" wire:model="title" placeholder="e.g., Tuition Receipt - Fall 2024" />
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-label for="document_type" value="{{ __('Document Type') }}" />
                    <select id="document_type" wire:model="document_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select type</option>
                        <option value="receipt">Receipt</option>
                        <option value="permit">Permit</option>
                        <option value="id">ID</option>
                        <option value="certificate">Certificate</option>
                        @if(auth()->user()->canEdit())
                        <option value="memo">Memo</option>
                        <option value="report">Report</option>
                        <option value="contract">Contract</option>
                        <option value="invoice">Invoice</option>
                        @endif
                        <option value="other">Other</option>
                    </select>
                    @error('document_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-label for="description" value="{{ __('Description (Optional)') }}" />
                    <textarea id="description" wire:model="description" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Add any notes about this document..."></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-label for="file" value="{{ __('File') }}" />
                    <input id="file" type="file" wire:model="file" class="mt-1 block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx" />
                    <p class="mt-1 text-xs text-gray-500">Accepted: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX (Max: 10MB)</p>
                    @error('file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    @if ($file)
                        <div class="mt-2 text-sm text-gray-600">
                            <i class="fas fa-file mr-1"></i> {{ $file->getClientOriginalName() }}
                        </div>
                    @endif
                </div>

                <div wire:loading wire:target="file" class="text-sm text-blue-600">
                    <i class="fas fa-spinner fa-spin mr-1"></i> Uploading file...
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="resetForm" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-3" wire:click="uploadDocument" wire:loading.attr="disabled" wire:target="file">
                {{ __('Upload') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingDelete">
        <x-slot name="title">
            {{ __('Delete Document') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this document? This action cannot be undone.') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingDelete', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="deleteDocument" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
