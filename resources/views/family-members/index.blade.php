@extends('layouts.app')

@section('title', 'Anggota Keluarga - E-Kartu Keluarga')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Anggota Keluarga</h1>
        <a href="{{ route('family-members.create') }}" class="inline-flex items-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span class="hidden sm:inline">Tambah Anggota Keluarga</span>
            <span class="sm:hidden">Tambah Anggota</span>
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <!-- Mobile Card View -->
        <div class="lg:hidden">
            <div class="divide-y divide-gray-200">
                @forelse($familyMembers as $member)
                <div class="p-4">
                    <div class="space-y-3">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $member->name }}</p>
                                <p class="text-sm text-gray-600">NIK: {{ $member->nik }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $member->gender == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $member->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="text-sm text-gray-500 space-y-1">
                            <p><span class="font-medium">Kartu Keluarga:</span> {{ $member->family->family_card_number }}</p>
                            <p><span class="font-medium">Kepala Keluarga:</span> {{ $member->family->head_of_family_name }}</p>
                            <p><span class="font-medium">Tanggal Lahir:</span> {{ $member->date_of_birth->format('d/m/Y') }}</p>
                            <p><span class="font-medium">Hubungan:</span> {{ $member->relationship_to_head }}</p>
                            <p><span class="font-medium">Status:</span> 
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $member->status == 'tetap' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2">
                            <a href="{{ route('family-members.edit', $member->id) }}" class="text-yellow-600 hover:text-yellow-900 text-sm font-medium">Edit</a>
                            <form action="{{ route('family-members.destroy', $member->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota keluarga ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center">
                    <p class="text-sm text-gray-500">Belum ada data anggota keluarga</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kartu Keluarga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hubungan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($familyMembers as $member)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member->nik }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $member->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $member->family->family_card_number }}<br>
                            <span class="text-xs text-gray-400">{{ $member->family->head_of_family_name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $member->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $member->date_of_birth->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $member->relationship_to_head }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $member->status == 'tetap' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                {{ ucfirst($member->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('family-members.edit', $member->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form action="{{ route('family-members.destroy', $member->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota keluarga ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data anggota keluarga</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($familyMembers->hasPages())
        <div class="bg-white px-3 sm:px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $familyMembers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
