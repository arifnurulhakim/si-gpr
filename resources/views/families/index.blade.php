@extends('layouts.app')

@section('title', 'Kartu Keluarga - E-Kartu Keluarga')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Kartu Keluarga</h1>
        <a href="{{ route('families.create') }}" class="inline-flex items-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span class="hidden sm:inline">Tambah Kartu Keluarga</span>
            <span class="sm:hidden">Tambah KK</span>
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <!-- Mobile Card View -->
        <div class="lg:hidden">
            <div class="divide-y divide-gray-200">
                @forelse($families as $family)
                <div class="p-4">
                    <div class="space-y-3">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $family->family_card_number }}</p>
                                <p class="text-sm text-gray-600">{{ $family->head_of_family_name }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $family->status == 'tetap' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ ucfirst($family->status) }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $family->familyMembers->count() }} orang
                                </span>
                            </div>
                        </div>
                        
                        <div class="text-sm text-gray-500">
                            <p>{{ $family->address }}</p>
                            <p class="text-xs text-gray-400 mt-1">RT {{ $family->rt }} / RW {{ $family->rw }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2">
                            <div class="flex space-x-2">
                                <a href="{{ route('families.show', $family->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Lihat</a>
                                <a href="{{ route('families.edit', $family->id) }}" class="text-yellow-600 hover:text-yellow-900 text-sm font-medium">Edit</a>
                            </div>
                            <form action="{{ route('families.destroy', $family->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kartu keluarga ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center">
                    <p class="text-sm text-gray-500">Belum ada data kartu keluarga</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. KK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kepala Keluarga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anggota</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($families as $family)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $family->family_card_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $family->head_of_family_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <div>{{ $family->address }}</div>
                            <div class="text-xs text-gray-400">RT {{ $family->rt }} / RW {{ $family->rw }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $family->status == 'tetap' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                {{ ucfirst($family->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $family->familyMembers->count() }} orang</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('families.show', $family->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                <a href="{{ route('families.edit', $family->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form action="{{ route('families.destroy', $family->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kartu keluarga ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data kartu keluarga</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($families->hasPages())
        <div class="bg-white px-3 sm:px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $families->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
