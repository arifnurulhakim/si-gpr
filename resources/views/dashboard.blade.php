@extends('layouts.app')

@section('title', 'Dashboard - E-Kartu Keluarga')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Kartu Keluarga</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $totalFamilies }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Anggota</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $totalMembers }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Permintaan Pending</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $pendingRequests }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Periode Air Aktif</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $activeWaterPeriods }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Tagihan Pending</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $userPendingBills ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @if(auth()->user()->isAdmin())
    <!-- Water Usage Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Periode Air</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $totalWaterPeriods }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Pembayaran Lunas</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $paidWaterPayments }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Menunggu Bayar</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $pendingWaterPayments }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Record Air</dt>
                            <dd class="text-base sm:text-lg font-medium text-gray-900">{{ $totalWaterRecords }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Families -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:p-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900 mb-4">Kartu Keluarga Terbaru</h3>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-3">
                @forelse($recentFamilies as $family)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="space-y-2">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $family->family_card_number }}</p>
                                <p class="text-sm text-gray-600">{{ $family->head_of_family_name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $family->address }}</p>
                            </div>
                            <a href="{{ route('families.show', $family->id) }}" class="ml-3 text-indigo-600 hover:text-indigo-900 text-sm font-medium">Lihat</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-sm text-gray-500">Belum ada data kartu keluarga</p>
                </div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. KK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kepala Keluarga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentFamilies as $family)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $family->family_card_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $family->head_of_family_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $family->address }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('families.show', $family->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data kartu keluarga</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(auth()->user()->isAdmin())
    <!-- Recent Water Records -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Record Air Terbaru</h3>
                <a href="{{ route('water-periods.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Lihat Semua</a>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-3">
                @forelse($recentWaterRecords as $record)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="space-y-2">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $record->family->family_card_number }}</p>
                                <p class="text-sm text-gray-600">{{ $record->family->head_of_family_name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $record->waterPeriod->period_name }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $record->payment_status === 'LUNAS' ? 'bg-green-100 text-green-800' : ($record->payment_status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ $record->payment_status }}
                                </span>
                                <a href="{{ route('water-usage.show', [$record->waterPeriod->id, $record->id]) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-sm text-gray-500">Belum ada data record air</p>
                </div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemakaian</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentWaterRecords as $record)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $record->family->family_card_number }}</div>
                                <div class="text-sm text-gray-500">{{ $record->family->head_of_family_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->waterPeriod->period_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->usage_amount }} M3</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $record->payment_status === 'LUNAS' ? 'bg-green-100 text-green-800' : ($record->payment_status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ $record->payment_status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('water-usage.show', [$record->waterPeriod->id, $record->id]) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data record air</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:p-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                @if(auth()->user()->isAdmin())
                <a href="{{ route('families.create') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 sm:py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="hidden sm:inline">Tambah Kartu Keluarga</span>
                    <span class="sm:hidden">Tambah KK</span>
                </a>
                <a href="{{ route('family-members.create') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 sm:py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span class="hidden sm:inline">Tambah Anggota Keluarga</span>
                    <span class="sm:hidden">Tambah Anggota</span>
                </a>
                <a href="{{ route('water-periods.create') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 sm:py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="hidden sm:inline">Tambah Periode Air</span>
                    <span class="sm:hidden">Tambah Periode</span>
                </a>
                @else
                <a href="{{ route('my-family') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 sm:py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="hidden sm:inline">Data Keluarga Saya</span>
                    <span class="sm:hidden">Data Keluarga</span>
                </a>
                <a href="{{ route('my-water-bills') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 sm:py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    <span class="hidden sm:inline">Tagihan Air Saya</span>
                    <span class="sm:hidden">Tagihan Air</span>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
