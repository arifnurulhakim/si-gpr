@extends('layouts.app')

@section('title', 'Edit Kartu Keluarga - SI-GPR')

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
            <form action="{{ route('families.update', $family->id) }}" method="POST" enctype="multipart/form-data">
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
                        <label for="block" class="block text-sm font-medium text-gray-700">Blok</label>
                        <input type="text" name="block" id="block" value="{{ old('block', $family->block) }}"
                               placeholder="Contoh: D1-12 atau D1-12A"
                               maxlength="10"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        <p class="mt-1 text-sm text-gray-500">Format: Huruf-Angka-Angka atau Huruf-Angka-Angka-Huruf (contoh: D1-12 atau D1-12A)</p>
                        @error('block')
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

                    <div class="sm:col-span-2">
                        <label for="family_card_image" class="block text-sm font-medium text-gray-700">Upload Kartu Keluarga</label>

                        @if($family->family_card_image)
                        <div class="mt-2 mb-4">
                            <p class="text-sm text-gray-600 mb-2">Kartu keluarga saat ini:</p>
                            <img src="{{ asset('storage/' . $family->family_card_image) }}" alt="Kartu Keluarga" class="h-32 w-auto object-cover rounded-lg border">
                        </div>
                        @endif

                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="family_card_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>{{ $family->family_card_image ? 'Ganti file' : 'Upload file' }}</span>
                                        <input id="family_card_image" name="family_card_image" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG sampai 2MB</p>
                            </div>
                        </div>
                        @error('family_card_image')
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format block input (D1-12 or D1-12A format)
    const blockInput = document.getElementById('block');
    if (blockInput) {
        blockInput.addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();

            // Remove any non-alphanumeric characters except dash
            value = value.replace(/[^A-Z0-9-]/g, '');

            // Auto-format: D1-12 or D1-12A
            if (value.length > 0) {
                // First character should be letter
                if (!/^[A-Z]/.test(value)) {
                    value = value.replace(/^[^A-Z]*/, '');
                }

                // After first letter, add dash after number
                if (value.length > 1 && /^[A-Z]\d+$/.test(value)) {
                    value = value.replace(/^([A-Z])(\d+)$/, '$1$2-');
                }

                // Limit to format D1-12A (max 6 characters) or D1-12 (max 5 characters)
                if (value.length > 6) {
                    value = value.substring(0, 6);
                }
            }

            e.target.value = value;
        });
    }
});
</script>
@endsection
