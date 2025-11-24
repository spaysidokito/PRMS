<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resource Analytics') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Export Button Bar --}}
            <div class="mb-6 flex justify-end px-4 sm:px-0">
                <a href="{{ route('analytics.export', request()->query()) }}"
                   class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition btn-click">
                    <i class="fas fa-download mr-2"></i> Export CSV
                </a>
            </div>

            <!-- Filters -->
            <div class="content-card mb-6">
                <div class="content-card-header mb-4">
                    <h3 class="text-lg font-semibold">Filters</h3>
                </div>
                <form method="GET" action="{{ route('analytics.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Form Type</label>
                        <select name="form_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="all" {{ $formType === 'all' ? 'selected' : '' }}>All Forms</option>
                            <option value="soa" {{ $formType === 'soa' ? 'selected' : '' }}>SOA</option>
                            <option value="gtc" {{ $formType === 'gtc' ? 'selected' : '' }}>GTC</option>
                            <option value="pod" {{ $formType === 'pod' ? 'selected' : '' }}>POD</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Time Period</label>
                        <select name="days" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="7" {{ $days == 7 ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="30" {{ $days == 30 ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="90" {{ $days == 90 ? 'selected' : '' }}>Last 90 Days</option>
                            <option value="365" {{ $days == 365 ? 'selected' : '' }}>Last Year</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="md:col-span-4 flex gap-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            <i class="fas fa-filter mr-2"></i> Apply Filters
                        </button>
                        <a href="{{ route('analytics.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            <i class="fas fa-redo mr-2"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Summary Statistics -->
            <div class="content-card mb-6">
                <div class="content-card-header mb-4">
                    <h3 class="text-lg font-semibold">Summary Statistics</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <i class="fas fa-eye text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Views</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_views']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-download text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Downloads</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_downloads']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-search text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Previews</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_previews']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-orange-500 rounded-md p-3">
                            <i class="fas fa-upload text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Uploads</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_uploads']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Unique Users</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['unique_users']) }}</p>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Top Users -->
                <div class="content-card">
                    <div class="content-card-header mb-4">
                        <h3 class="text-lg font-semibold">
                            <i class="fas fa-user-chart mr-2"></i> Top Users
                        </h3>
                    </div>
                    <div class="space-y-3">
                        @forelse($topUsers as $index => $userStat)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-sm mr-3">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $userStat->user->name ?? 'Unknown' }}</p>
                                        <p class="text-sm text-gray-500">{{ $userStat->user->email ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-semibold">
                                    {{ number_format($userStat->access_count) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No data available</p>
                        @endforelse
                    </div>
                </div>

                <!-- Most Accessed Forms -->
                <div class="content-card">
                    <div class="content-card-header mb-4">
                        <h3 class="text-lg font-semibold">
                            <i class="fas fa-file-alt mr-2"></i> Most Accessed Forms
                        </h3>
                    </div>
                    <div class="space-y-3">
                        @forelse($topForms as $index => $form)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-semibold text-sm mr-3">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $form->form_name }}</p>
                                        <p class="text-sm text-gray-500">{{ strtoupper($form->form_type) }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                    {{ number_format($form->access_count) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No data available</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="content-card">
                <div class="content-card-header mb-4">
                    <h3 class="text-lg font-semibold">
                        <i class="fas fa-history mr-2"></i> Recent Activity
                    </h3>
                </div>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Form Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Form Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentActivity as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $log->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $log->user->name ?? 'Guest' }}</div>
                                        <div class="text-sm text-gray-500">{{ $log->user->email ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($log->form_type === 'soa') bg-blue-100 text-blue-800
                                            @elseif($log->form_type === 'gtc') bg-green-100 text-green-800
                                            @else bg-purple-100 text-purple-800
                                            @endif">
                                            {{ strtoupper($log->form_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $log->form_name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($log->action === 'view') bg-blue-100 text-blue-800
                                            @elseif($log->action === 'download') bg-green-100 text-green-800
                                            @elseif($log->action === 'preview') bg-purple-100 text-purple-800
                                            @else bg-orange-100 text-orange-800
                                            @endif">
                                            <i class="fas fa-{{ $log->action === 'view' ? 'eye' : ($log->action === 'download' ? 'download' : ($log->action === 'preview' ? 'search' : 'upload')) }} mr-1"></i>
                                            {{ ucfirst($log->action) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $log->ip_address ?? 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No activity recorded yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden divide-y divide-gray-200">
                    @forelse($recentActivity as $log)
                        <div class="p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900">{{ $log->user->name ?? 'Guest' }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->user->email ?? 'N/A' }}</div>
                                </div>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ml-2
                                    @if($log->action === 'view') bg-blue-100 text-blue-800
                                    @elseif($log->action === 'download') bg-green-100 text-green-800
                                    @elseif($log->action === 'preview') bg-purple-100 text-purple-800
                                    @else bg-orange-100 text-orange-800
                                    @endif">
                                    <i class="fas fa-{{ $log->action === 'view' ? 'eye' : ($log->action === 'download' ? 'download' : ($log->action === 'preview' ? 'search' : 'upload')) }} mr-1"></i>
                                    {{ ucfirst($log->action) }}
                                </span>
                            </div>

                            <div class="space-y-2 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-calendar w-5 text-gray-400"></i>
                                    <span class="ml-2">{{ $log->created_at->format('M d, Y H:i') }}</span>
                                </div>

                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-file-alt w-5 text-gray-400"></i>
                                    <span class="ml-2">{{ $log->form_name ?? 'N/A' }}</span>
                                    <span class="px-2 ml-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($log->form_type === 'soa') bg-blue-100 text-blue-800
                                        @elseif($log->form_type === 'gtc') bg-green-100 text-green-800
                                        @else bg-purple-100 text-purple-800
                                        @endif">
                                        {{ strtoupper($log->form_type) }}
                                    </span>
                                </div>

                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-network-wired w-5 text-gray-400"></i>
                                    <span class="ml-2 text-xs">{{ $log->ip_address ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">
                            No activity recorded yet
                        </div>
                    @endforelse
                </div>

                @if($recentActivity->hasPages())
                    <div class="px-4 sm:px-6 py-4 border-t border-gray-200">
                        {{ $recentActivity->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
