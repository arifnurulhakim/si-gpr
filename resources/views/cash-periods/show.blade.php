@extends('layouts.app')

@section('title', 'Detail Periode Kas - SI-GPR')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Detail Periode Kas</h1>
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
            <a href="{{ route('cash-records.create', $period->id) }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="hidden sm:inline">Input Data Kas</span>
                <span class="sm:hidden">Input</span>
            </a>
            <a href="{{ route('cash-periods.edit', $period->id) }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 transition-colors">
                Edit
            </a>
            <a href="{{ route('cash-periods.index') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                Kembali
            </a>
        </div>
    </div>

    <!-- Info Period -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Informasi Periode Kas</h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Nama Periode</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $period->period_name }}</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kode Periode</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $period->period_code }}</dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Jatuh Tempo</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $period->due_date->format('d M Y') }}</dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Total Kas Lunas</dt>
                    <dd class="mt-1 text-sm font-medium text-green-600 sm:mt-0 sm:col-span-2">Rp {{ number_format($records->where('payment_status', 'LUNAS')->sum('total_payment')) }}</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Total Kas Belum Lunas</dt>
                    <dd class="mt-1 text-sm font-medium text-red-600 sm:mt-0 sm:col-span-2">Rp {{ number_format($records->where('payment_status', '!=', 'LUNAS')->sum('total_payment')) }}</dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Blok Lunas</dt>
                    <dd class="mt-1 text-sm font-medium text-green-600 sm:mt-0 sm:col-span-2">{{ $records->where('payment_status', 'LUNAS')->count() }} blok</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Blok Belum Lunas</dt>
                    <dd class="mt-1 text-sm font-medium text-red-600 sm:mt-0 sm:col-span-2">{{ $records->where('payment_status', '!=', 'LUNAS')->count() }} blok</dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 sm:mt-0 sm:col-span-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $period->status === 'ACTIVE' ? 'bg-green-100 text-green-800' : ($period->status === 'CLOSED' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ $period->status }}
                        </span>
                    </dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Dibuat Oleh</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $period->createdBy->name ?? 'Admin' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Records Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
                <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Data Kas per KK/Blok</h3>
                <div class="flex items-center space-x-3">
                    <label for="per_page" class="text-sm font-medium text-gray-700">Tampilkan:</label>
                    <div class="relative">
                        <select id="per_page" name="per_page" onchange="updatePerPage(this.value)" class="appearance-none bg-white border border-gray-300 rounded-lg px-3 py-1 pr-6 text-sm font-medium text-gray-700 shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <option value="5" {{ request('per_page', 10) == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="lg:hidden">
            @forelse($records as $record)
            <div class="border-t border-gray-200 p-4">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="space-y-1">
                            <div>
                                <p class="text-xs font-medium text-gray-500">KK</p>
                                <p class="text-sm font-medium text-gray-900">{{ $record->family ? $record->family->family_card_number : '-' }}</p>
                                <p class="text-sm text-gray-600">{{ $record->family ? $record->family->head_of_family_name : '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Blok</p>
                                <p class="text-sm font-medium text-gray-900">{{ $record->residentBlock ? $record->residentBlock->block : '-' }}</p>
                                <p class="text-sm text-gray-600">{{ $record->residentBlock && $record->residentBlock->resident ? $record->residentBlock->resident->name : '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $record->payment_status === 'LUNAS' ? 'bg-green-100 text-green-800' : ($record->payment_status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : ($record->payment_status === 'PAYMENT_UPLOADED' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            {{ $record->payment_status }}
                        </span>
                    </div>
                </div>

                <div class="text-sm text-gray-500 mt-2">
                    <p>Uang Kas: Rp {{ number_format($record->cash_amount) }}</p>
                    <p>Uang Ronda: Rp {{ number_format($record->patrol_amount) }}</p>
                    <p>Lain-lain: Rp {{ number_format($record->other_amount) }}</p>
                    <p>Total: Rp {{ number_format($record->total_payment) }}</p>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex space-x-2">
                        <a href="{{ route('cash-records.show', [$period->id, $record->id]) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Lihat</a>
                        <a href="{{ route('cash-records.edit', [$period->id, $record->id]) }}" class="text-yellow-600 hover:text-yellow-900 text-sm font-medium">Edit</a>
                    </div>
                    <button onclick="confirmRecordDelete(this)" data-record-id="{{ $record->id }}" data-record-name="Blok {{ $record->residentBlock ? $record->residentBlock->block : '' }}" class="text-red-600 hover:text-red-900 text-sm font-medium">Hapus</button>
                </div>
            </div>
            @empty
            <div class="border-t border-gray-200 p-8 text-center">
                <p class="text-sm text-gray-500">Belum ada data kas</p>
            </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uang Kas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uang Ronda</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lain-lain</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($records as $record)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $record->family ? $record->family->family_card_number : '-' }}</div>
                            <div class="text-sm text-gray-500">{{ $record->family ? $record->family->head_of_family_name : '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $record->residentBlock ? $record->residentBlock->block : '-' }}</div>
                            <div class="text-sm text-gray-500">{{ $record->residentBlock && $record->residentBlock->resident ? $record->residentBlock->resident->name : '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp {{ number_format($record->cash_amount) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp {{ number_format($record->patrol_amount) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp {{ number_format($record->other_amount) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Rp {{ number_format($record->total_payment) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $record->payment_status === 'LUNAS' ? 'bg-green-100 text-green-800' : ($record->payment_status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : ($record->payment_status === 'PAYMENT_UPLOADED' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                {{ $record->payment_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('cash-records.show', [$period->id, $record->id]) }}" class="text-indigo-600 hover:text-indigo-900" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('cash-records.edit', [$period->id, $record->id]) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button onclick="confirmRecordDelete(this)" data-record-id="{{ $record->id }}" data-record-name="Blok {{ $record->residentBlock ? $record->residentBlock->block : '' }}" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data kas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
        <div class="bg-white px-4 py-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                <!-- Info -->
                <div class="text-sm text-gray-700">
                    Menampilkan {{ $records->firstItem() ?? 0 }} sampai {{ $records->lastItem() ?? 0 }} dari {{ $records->total() }} data
                </div>

                <!-- Pagination -->
                <div class="flex items-center space-x-1">
                    {{-- Previous Page Link --}}
                    @if ($records->onFirstPage())
                        <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $records->appends(request()->query())->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($records->getUrlRange(1, $records->lastPage()) as $page => $url)
                        @if ($page == $records->currentPage())
                            <span class="px-3 py-2 text-sm font-medium text-white bg-indigo-600 border border-indigo-600 rounded-lg">{{ $page }}</span>
                        @else
                            <a href="{{ $records->appends(request()->query())->url($page) }}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($records->hasMorePages())
                        <a href="{{ $records->appends(request()->query())->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors">
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

<!-- Delete Record Confirmation Modal -->
<div id="deleteRecordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Hapus Record Kas</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus record <strong id="recordIdentifier"></strong>?
                </p>
                <p class="text-sm text-red-600 mt-2">
                    <strong>PERINGATAN:</strong> Tindakan ini akan menghapus data record dan bukti pembayaran (jika ada). Tindakan ini tidak dapat dibatalkan!
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="deleteRecordForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Ya, Hapus Record
                    </button>
                </form>
                <button onclick="closeDeleteRecordModal()" class="mt-3 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
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
    window.location.href = url.toString();
}

function confirmRecordDelete(button) {
    const recordId = button.getAttribute('data-record-id');
    const recordName = button.getAttribute('data-record-name');
    document.getElementById('recordIdentifier').textContent = recordName;
    document.getElementById('deleteRecordForm').action = `/cash-periods/{{ $period->id }}/records/${recordId}`;
    document.getElementById('deleteRecordModal').classList.remove('hidden');
}

function closeDeleteRecordModal() {
    document.getElementById('deleteRecordModal').classList.add('hidden');
}
</script>
@endsection
