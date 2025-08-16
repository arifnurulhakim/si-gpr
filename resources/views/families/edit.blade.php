@extends('layouts.app')

@section('title', 'Edit Kartu Keluarga - E-Kartu Keluarga')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Kartu Keluarga</h1>
        <a href="{{ route('families.show', $family->id) }}" class="inline-flex items-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:p-6">
            <form action="{{ route('families.update', $family->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2">
                    <div>
                        <label for="family_card_number" class="block text-sm font-medium text-gray-700">Nomor Kartu Keluarga</label>
                        <input type="text" name="family_card_number" id="family_card_number" value="{{ old('family_card_number', $family->family_card_number) }}" required
                               placeholder="Contoh: 3273011234567890"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('family_card_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="head_of_family_name" class="block text-sm font-medium text-gray-700">Nama Kepala Keluarga</label>
                        <input type="text" name="head_of_family_name" id="head_of_family_name" value="{{ old('head_of_family_name', $family->head_of_family_name) }}" required
                               placeholder="Contoh: Ahmad Supriadi"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('head_of_family_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="address" id="address" rows="4" required
                                  placeholder="Contoh: Jl. Raya Bogor No. 123, Gang Melati"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">{{ old('address', $family->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rt" class="block text-sm font-medium text-gray-700">RT</label>
                        <input type="text" name="rt" id="rt" value="{{ old('rt', $family->rt) }}" required
                               placeholder="Contoh: 001"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('rt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rw" class="block text-sm font-medium text-gray-700">RW</label>
                        <input type="text" name="rw" id="rw" value="{{ old('rw', $family->rw) }}" required
                               placeholder="Contoh: 005"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('rw')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="village" class="block text-sm font-medium text-gray-700">Desa/Kelurahan</label>
                        <input type="text" name="village" id="village" value="{{ old('village', $family->village) }}" required
                               placeholder="Contoh: Kelurahan Cibinong"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('village')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sub_district" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                        <input type="text" name="sub_district" id="sub_district" value="{{ old('sub_district', $family->sub_district) }}" required
                               placeholder="Contoh: Cibinong"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('sub_district')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $family->city) }}" required
                               placeholder="Contoh: Bogor"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <input type="text" name="province" id="province" value="{{ old('province', $family->province) }}" required
                               placeholder="Contoh: Jawa Barat"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('province')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $family->postal_code) }}" required
                               placeholder="Contoh: 16913"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status Keluarga</label>
                        <select name="status" id="status" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                            <option value="">Pilih Status</option>
                            <option value="tetap" {{ old('status', $family->status) == 'tetap' ? 'selected' : '' }}>Tetap</option>
                            <option value="domisili" {{ old('status', $family->status) == 'domisili' ? 'selected' : '' }}>Domisili</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('families.show', $family->id) }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
