@extends('layouts.app')

@section('title', 'Data Keluarga Saya - SI-GPR')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Data Keluarga Saya</h1>
            @if($residentBlock)
            <p class="mt-1 text-sm text-gray-600">
                Blok: <span class="font-semibold text-indigo-600">{{ $residentBlock->block }}</span>
            </p>
            @endif
        </div>
        <div class="flex space-x-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                {{ auth()->user()->name }}
            </span>
        </div>
    </div>

    <!-- Family Information -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Informasi Kartu Keluarga</h3>
            @if(isset($family->hasNoKK) && $family->hasNoKK)
            <div class="mt-2 p-3 bg-gray-50 border border-gray-200 rounded-md">
                <p class="text-sm text-gray-600 text-center">
                    Data belum ada
                </p>
            </div>
            @endif
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Nomor Kartu Keluarga</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-mono">
                        @if($family->family_card_number)
                            {{ $family->family_card_number }}
                        @else
                            <span class="text-gray-400">Data belum ada</span>
                        @endif
                    </dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Nama Kepala Keluarga</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($family->head_of_family_name)
                            {{ $family->head_of_family_name }}
                        @else
                            <span class="text-gray-400">Data belum ada</span>
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($family->address)
                            {{ $family->address }}
                        @else
                            <span class="text-gray-400">Data belum ada</span>
                        @endif
                    </dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">RT/RW</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($family->rt && $family->rw)
                            RT {{ $family->rt }} / RW {{ $family->rw }}
                        @else
                            <span class="text-gray-400">Data belum ada</span>
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Desa/Kelurahan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($family->village)
                            {{ $family->village }}
                        @else
                            <span class="text-gray-400">Data belum ada</span>
                        @endif
                    </dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kecamatan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($family->sub_district)
                            {{ $family->sub_district }}
                        @else
                            <span class="text-gray-400">Data belum ada</span>
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kota/Kabupaten</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($family->city)
                            {{ $family->city }}
                        @else
                            <span class="text-gray-400">Data belum ada</span>
                        @endif
                    </dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Provinsi</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($family->province)
                            {{ $family->province }}
                        @else
                            <span class="text-gray-400">Data belum ada</span>
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kode Pos</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($family->postal_code)
                            {{ $family->postal_code }}
                        @else
                            <span class="text-gray-400">Data belum ada</span>
                        @endif
                    </dd>
                </div>
                @if($family->block)
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Blok</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $family->block }}</dd>
                </div>
                @endif
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($family->status)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $family->status == 'tetap' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                {{ ucfirst($family->status) }}
                            </span>
                        @else
                            <span class="text-gray-400">Data belum ada</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Family Members -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Anggota Keluarga</h3>
        </div>
        <div class="border-t border-gray-200">
            <div class="divide-y divide-gray-200">
                @forelse($family->familyMembers as $member)
                <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3">
                                <h4 class="text-sm font-medium text-gray-900">{{ $member->name }}</h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $member->relationship_to_head === 'Kepala Keluarga' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $member->relationship_to_head }}
                                </span>
                            </div>
                            <div class="mt-1 text-sm text-gray-500">
                                <p>NIK: {{ $member->nik }}</p>
                                <p>Jenis Kelamin: {{ $member->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                <p>Tanggal Lahir: {{ $member->date_of_birth->format('d/m/Y') }}</p>
                                <p>Status Perkawinan: {{ $member->marital_status }}</p>
                                <p>Kewarganegaraan: {{ $member->citizenship }}</p>
                                <p>Status:
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $member->status == 'tetap' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6 text-center">
                    <p class="text-sm text-gray-500">Belum ada anggota keluarga</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
