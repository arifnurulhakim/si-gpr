@extends('layouts.app')

@section('title', 'Periode Air - E-Kartu Keluarga')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Periode Air</h1>
        <div class="flex space-x-2">
            <a href="{{ route('water-periods.create') }}" class="inline-flex items-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="hidden sm:inline">Tambah Periode Air</span>
                <span class="sm:hidden">Tambah</span>
            </a>
        </div>
    </div>

    <!-- Per Page Selector -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <div class="flex items-center space-x-3">
            <label for="per_page" class="text-sm font-medium text-gray-700">Tampilkan:</label>
            <div class="relative">
                <select id="per_page" name="per_page" onchange="updatePerPage(this.value)" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm font-medium text-gray-700 shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <option value="5" {{ request('per_page', 10) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
            <span class="text-sm text-gray-500">per halaman</span>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <!-- Mobile Card View -->
        <div class="lg:hidden">
            <div class="divide-y divide-gray-200">
                @forelse($periods as $period)
                <div class="p-4">
                    <div class="space-y-3">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $period->period_name }}</p>
                                <p class="text-sm text-gray-600">{{ $period->period_code }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $period->status == 'ACTIVE' ? 'bg-green-100 text-green-800' : ($period->status == 'CLOSED' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ $period->status }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $period->water_usage_records_count }} record
                                </span>
                            </div>
                        </div>

                        <div class="text-sm text-gray-500">
                            <p>Due: {{ $period->due_date->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400 mt-1">Harga: Rp {{ number_format($period->price_per_m3) }}/M3</p>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <div class="flex space-x-2">
                                <a href="{{ route('water-periods.show', $period->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Lihat</a>
                                <a href="{{ route('water-periods.edit', $period->id) }}" class="text-yellow-600 hover:text-yellow-900 text-sm font-medium">Edit</a>
                            </div>
                            <div class="flex space-x-2">
                                @if($period->status === 'ACTIVE')
                                <form action="{{ route('water-periods.close', $period->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menutup periode ini?')">
                                    @csrf
                                    <button type="submit" class="text-orange-600 hover:text-orange-900 text-sm font-medium">Tutup</button>
                                </form>
                                @endif
                                <button onclick="confirmPermanentDelete('{{ $period->id }}', '{{ $period->period_name }}')" class="text-red-600 hover:text-red-900 text-sm font-medium">Hapus Permanen</button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center">
                    <p class="text-sm text-gray-500">Belum ada data periode air</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'period_name', 'sort_order' => request('sort_by') == 'period_name' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700 group">
                                <span>Nama Periode</span>
                                <div class="flex flex-col">
                                    @if(request('sort_by') == 'period_name')
                                        @if(request('sort_order') == 'asc')
                                            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    @else
                                        <svg class="w-3 h-3 text-gray-300 group-hover:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'period_code', 'sort_order' => request('sort_by') == 'period_code' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700 group">
                                <span>Kode Periode</span>
                                <div class="flex flex-col">
                                    @if(request('sort_by') == 'period_code')
                                        @if(request('sort_order') == 'asc')
                                            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    @else
                                        <svg class="w-3 h-3 text-gray-300 group-hover:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'due_date', 'sort_order' => request('sort_by') == 'due_date' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700 group">
                                <span>Jatuh Tempo</span>
                                <div class="flex flex-col">
                                    @if(request('sort_by') == 'due_date')
                                        @if(request('sort_order') == 'asc')
                                            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    @else
                                        <svg class="w-3 h-3 text-gray-300 group-hover:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'price_per_m3', 'sort_order' => request('sort_by') == 'price_per_m3' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700 group">
                                <span>Harga/M3</span>
                                <div class="flex flex-col">
                                    @if(request('sort_by') == 'price_per_m3')
                                        @if(request('sort_order') == 'asc')
                                            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    @else
                                        <svg class="w-3 h-3 text-gray-300 group-hover:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'status', 'sort_order' => request('sort_by') == 'status' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700 group">
                                <span>Status</span>
                                <div class="flex flex-col">
                                    @if(request('sort_by') == 'status')
                                        @if(request('sort_order') == 'asc')
                                            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    @else
                                        <svg class="w-3 h-3 text-gray-300 group-hover:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Record</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($periods as $period)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $period->period_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $period->period_code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $period->due_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($period->price_per_m3) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $period->status == 'ACTIVE' ? 'bg-green-100 text-green-800' : ($period->status == 'CLOSED' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ $period->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $period->water_usage_records_count }} record</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('water-periods.show', $period->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Lihat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('water-periods.edit', $period->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                @if($period->status === 'ACTIVE')
                                <form action="{{ route('water-periods.close', $period->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menutup periode ini?')">
                                    @csrf
                                    <button type="submit" class="text-orange-600 hover:text-orange-900" title="Tutup Periode">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                                <button onclick="confirmPermanentDelete('{{ $period->id }}', '{{ $period->period_name }}')" class="text-red-600 hover:text-red-900" title="Hapus Permanen">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data periode air</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($periods->hasPages())
        <div class="bg-white px-4 py-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                <!-- Info -->
                <div class="text-sm text-gray-700">
                    Menampilkan {{ $periods->firstItem() ?? 0 }} sampai {{ $periods->lastItem() ?? 0 }} dari {{ $periods->total() }} data
                </div>

                <!-- Pagination -->
                <div class="flex items-center space-x-1">
                    {{-- Previous Page Link --}}
                    @if ($periods->onFirstPage())
                        <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $periods->appends(request()->query())->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($periods->getUrlRange(1, $periods->lastPage()) as $page => $url)
                        @if ($page == $periods->currentPage())
                            <span class="px-3 py-2 text-sm font-medium text-white bg-indigo-600 border border-indigo-600 rounded-lg">{{ $page }}</span>
                        @else
                            <a href="{{ $periods->appends(request()->query())->url($page) }}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($periods->hasMorePages())
                        <a href="{{ $periods->appends(request()->query())->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @else
                        <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Permanent Delete Confirmation Modal -->
<div id="permanentDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Hapus Permanen</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus permanen periode <strong id="periodName"></strong>?
                </p>
                <p class="text-sm text-red-600 mt-2">
                    <strong>PERINGATAN:</strong> Tindakan ini akan menghapus semua data terkait termasuk record penggunaan air dan bukti pembayaran. Tindakan ini tidak dapat dibatalkan!
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="permanentDeleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Ya, Hapus Permanen
                    </button>
                </form>
                <button onclick="closePermanentDeleteModal()" class="mt-3 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function updatePerPage(value) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

function confirmPermanentDelete(periodId, periodName) {
    document.getElementById('periodName').textContent = periodName;
    document.getElementById('permanentDeleteForm').action = `/water-periods/${periodId}/force-delete`;
    document.getElementById('permanentDeleteModal').classList.remove('hidden');
}

function closePermanentDeleteModal() {
    document.getElementById('permanentDeleteModal').classList.add('hidden');
}
</script>
@endsection
