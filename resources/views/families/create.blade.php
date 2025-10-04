@extends('layouts.app')

@section('title', 'Tambah Kartu Keluarga - E-Kartu Keluarga')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Tambah Kartu Keluarga</h1>
        <a href="{{ route('families.index') }}" class="inline-flex items-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:p-6">
            <form action="{{ route('families.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2">
                    <div>
                        <label for="family_card_number" class="block text-sm font-medium text-gray-700">Nomor Kartu Keluarga</label>
                        <input type="text" name="family_card_number" id="family_card_number" value="{{ old('family_card_number') }}" required
                               placeholder="Contoh: 3273011234567890"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('family_card_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="head_of_family_name" class="block text-sm font-medium text-gray-700">Nama Kepala Keluarga</label>
                        <input type="text" name="head_of_family_name" id="head_of_family_name" value="{{ old('head_of_family_name') }}" required
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
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rt" class="block text-sm font-medium text-gray-700">RT</label>
                        <input type="text" name="rt" id="rt" value="{{ old('rt') }}" required
                               placeholder="Contoh: 001"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('rt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rw" class="block text-sm font-medium text-gray-700">RW</label>
                        <input type="text" name="rw" id="rw" value="{{ old('rw') }}" required
                               placeholder="Contoh: 005"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('rw')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="village" class="block text-sm font-medium text-gray-700">Desa/Kelurahan</label>
                        <input type="text" name="village" id="village" value="{{ old('village') }}" required
                               placeholder="Contoh: Kelurahan Cibinong"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('village')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sub_district" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                        <input type="text" name="sub_district" id="sub_district" value="{{ old('sub_district') }}" required
                               placeholder="Contoh: Cibinong"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('sub_district')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required
                               placeholder="Contoh: Bogor"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <input type="text" name="province" id="province" value="{{ old('province') }}" required
                               placeholder="Contoh: Jawa Barat"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('province')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required
                               placeholder="Contoh: 16913"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="block" class="block text-sm font-medium text-gray-700">Blok</label>
                        <input type="text" name="block" id="block" value="{{ old('block') }}"
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
                            <option value="tetap" {{ old('status') == 'tetap' ? 'selected' : '' }}>Tetap</option>
                            <option value="domisili" {{ old('status') == 'domisili' ? 'selected' : '' }}>Domisili</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="family_card_image" class="block text-sm font-medium text-gray-700">Upload Kartu Keluarga</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="family_card_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload file</span>
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

                <!-- Family Members Section -->
                <div class="mt-8 border-t border-gray-200 pt-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Anggota Keluarga</h3>
                            <p class="text-sm text-gray-500" id="member-count">1 anggota (Kepala Keluarga)</p>
                        </div>
                        <button type="button" id="add-member-btn" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Anggota
                        </button>
                    </div>

                    <div id="family-members-container">
                        <!-- Head of Family (Required) -->
                        <div class="member-form bg-gray-50 p-4 rounded-lg mb-4" data-member-type="head">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-md font-medium text-gray-900">Kepala Keluarga (Wajib)</h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Wajib
                                </span>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                                    <input type="text" name="family_members[0][nik]" required
                                           placeholder="Contoh: 3273011234567890"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <input type="text" name="family_members[0][name]" required
                                           placeholder="Contoh: Ahmad Supriadi"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                    <select name="family_members[0][gender]" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <input type="date" name="family_members[0][date_of_birth]" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                                    <select name="family_members[0][marital_status]" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                                        <option value="">Pilih Status</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Hubungan dengan Kepala Keluarga</label>
                                    <select name="family_members[0][relationship_to_head]" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                                        <option value="">Pilih Hubungan</option>
                                        <option value="Kepala Keluarga">Kepala Keluarga</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                                    <select name="family_members[0][citizenship]" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                                        <option value="">Pilih Kewarganegaraan</option>
                                        <option value="WNI">WNI</option>
                                        <option value="WNA">WNA</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="family_members[0][status]" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                                        <option value="">Pilih Status</option>
                                        <option value="tetap">Tetap</option>
                                        <option value="domisili">Domisili</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Upload KTP</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload KTP</span>
                                                <input name="family_members[0][ktp_image]" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG sampai 2MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('families.index') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}
</style>
@endsection

@section('scripts')
<script>
let memberIndex = 1;

function createMemberForm(index) {
    const div = document.createElement('div');
    div.className = 'member-form bg-white border border-gray-200 p-4 rounded-lg mb-4 animate-fade-in';
    div.setAttribute('data-member-type', 'member');

    div.innerHTML = `
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-md font-medium text-gray-900">Anggota Keluarga ${index}</h4>
            <button type="button" class="remove-member-btn text-red-600 hover:text-red-900" title="Hapus Anggota">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="family_members[${index}][nik]" required
                       placeholder="Contoh: 3273011234567890"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="family_members[${index}][name]" required
                       placeholder="Contoh: Siti Aminah"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select name="family_members[${index}][gender]" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" name="family_members[${index}][date_of_birth]" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                <select name="family_members[${index}][marital_status]" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                    <option value="">Pilih Status</option>
                    <option value="Belum Kawin">Belum Kawin</option>
                    <option value="Kawin">Kawin</option>
                    <option value="Cerai Hidup">Cerai Hidup</option>
                    <option value="Cerai Mati">Cerai Mati</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Hubungan dengan Kepala Keluarga</label>
                <select name="family_members[${index}][relationship_to_head]" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                    <option value="">Pilih Hubungan</option>
                    <option value="Istri">Istri</option>
                    <option value="Anak">Anak</option>
                    <option value="Menantu">Menantu</option>
                    <option value="Cucu">Cucu</option>
                    <option value="Orang Tua">Orang Tua</option>
                    <option value="Mertua">Mertua</option>
                    <option value="Famili Lain">Famili Lain</option>
                    <option value="Pembantu">Pembantu</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                <select name="family_members[${index}][citizenship]" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                    <option value="">Pilih Kewarganegaraan</option>
                    <option value="WNI">WNI</option>
                    <option value="WNA">WNA</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="family_members[${index}][status]" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                    <option value="">Pilih Status</option>
                    <option value="tetap">Tetap</option>
                    <option value="domisili">Domisili</option>
                </select>
            </div>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700">Upload KTP</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                            <span>Upload KTP</span>
                            <input name="family_members[${index}][ktp_image]" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, JPEG sampai 2MB</p>
                </div>
            </div>
        </div>
    `;

    // Add event listener for remove button
    div.querySelector('.remove-member-btn').addEventListener('click', function() {
        // Add fade out animation before removing
        div.style.transition = 'all 0.3s ease-out';
        div.style.opacity = '0';
        div.style.transform = 'translateY(-10px)';

        setTimeout(() => {
            div.remove();
            // Update member count after removal
            updateMemberCount();
        }, 300);
    });

    return div;
}

// Update member count function
function updateMemberCount() {
    const memberForms = document.querySelectorAll('.member-form[data-member-type="member"]');
    const totalMembers = memberForms.length + 1; // +1 for head of family
    const memberCountElement = document.getElementById('member-count');

    if (totalMembers === 1) {
        memberCountElement.textContent = '1 anggota (Kepala Keluarga)';
    } else {
        memberCountElement.textContent = `${totalMembers} anggota (1 Kepala Keluarga + ${memberForms.length} anggota)`;
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const addMemberBtn = document.getElementById('add-member-btn');
    if (addMemberBtn) {
        addMemberBtn.addEventListener('click', function() {
            console.log('Add member button clicked');
            const container = document.getElementById('family-members-container');
            const memberForm = createMemberForm(memberIndex);

            // Insert the new form at the end of the container
            container.appendChild(memberForm);

            // Scroll to the newly added form
            memberForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            // Update member count
            updateMemberCount();

            memberIndex++;
        });
    } else {
        console.error('Add member button not found');
    }

    // Auto-fill head of family name from family form
    const headOfFamilyName = document.getElementById('head_of_family_name');
    if (headOfFamilyName) {
        headOfFamilyName.addEventListener('input', function() {
            const headMemberName = document.querySelector('input[name="family_members[0][name]"]');
            if (headMemberName && !headMemberName.value) {
                headMemberName.value = this.value;
            }
        });
    }

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
