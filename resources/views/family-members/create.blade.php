@extends('layouts.app')

@section('title', 'Tambah Masyarakat - E-Kartu Keluarga')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Tambah Warga</h1>
            <p class="text-sm text-gray-600 mt-1">Warga dapat dibuat tanpa keluarga terlebih dahulu</p>
        </div>
        <a href="{{ route('family-members.index') }}" class="inline-flex items-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:p-6">
            <form action="{{ route('family-members.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2">
                    <div>
                        <label for="family_id" class="block text-sm font-medium text-gray-700">
                            Kartu Keluarga
                            <span class="text-gray-500 font-normal">(Opsional)</span>
                        </label>
                        <select name="family_id" id="family_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                            <option value="">Tanpa Keluarga (Buat Warga Independen)</option>
                            @foreach($families as $family)
                                <option value="{{ $family->id }}" {{ $familyId == $family->id ? 'selected' : '' }}>
                                    {{ $family->family_card_number }} - {{ $family->head_of_family_name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika ingin membuat warga tanpa keluarga</p>
                        @error('family_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                        <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required maxlength="20"
                               placeholder="Contoh: 3273011234567890"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('nik')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               placeholder="Contoh: Siti Nurhaliza"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="gender" id="gender" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('date_of_birth')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="marital_status" class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                        <select name="marital_status" id="marital_status" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                            <option value="">Pilih Status</option>
                            <option value="BELUM KAWIN" {{ old('marital_status') == 'BELUM KAWIN' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="KAWIN" {{ old('marital_status') == 'KAWIN' ? 'selected' : '' }}>Kawin</option>
                            <option value="CERAI HIDUP" {{ old('marital_status') == 'CERAI HIDUP' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="CERAI MATI" {{ old('marital_status') == 'CERAI MATI' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                        @error('marital_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="relationship_to_head" class="block text-sm font-medium text-gray-700">
                            Hubungan dengan Kepala Keluarga
                            <span class="text-gray-500 font-normal">(Opsional)</span>
                        </label>
                        <select name="relationship_to_head" id="relationship_to_head"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                            <option value="">Pilih Hubungan</option>
                            <option value="KEPALA KELUARGA" {{ old('relationship_to_head') == 'KEPALA KELUARGA' ? 'selected' : '' }}>Kepala Keluarga</option>
                            <option value="SUAMI" {{ old('relationship_to_head') == 'SUAMI' ? 'selected' : '' }}>Suami</option>
                            <option value="ISTRI" {{ old('relationship_to_head') == 'ISTRI' ? 'selected' : '' }}>Istri</option>
                            <option value="ANAK" {{ old('relationship_to_head') == 'ANAK' ? 'selected' : '' }}>Anak</option>
                            <option value="ORANGTUA" {{ old('relationship_to_head') == 'ORANGTUA' ? 'selected' : '' }}>Orang Tua</option>
                            <option value="FAMILI LAIN" {{ old('relationship_to_head') == 'FAMILI LAIN' ? 'selected' : '' }}>Famili Lain</option>
                            <option value="PEMBANTU" {{ old('relationship_to_head') == 'PEMBANTU' ? 'selected' : '' }}>Pembantu</option>
                            <option value="LAINNYA" {{ old('relationship_to_head') == 'LAINNYA' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('relationship_to_head')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="citizenship" class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                        <input type="text" name="citizenship" id="citizenship" value="{{ old('citizenship', 'WNI') }}" required maxlength="3"
                               placeholder="Contoh: WNI"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base px-3 sm:px-4 py-2 sm:py-3">
                        @error('citizenship')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
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
                        <label for="ktp_image" class="block text-sm font-medium text-gray-700">Upload KTP</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="ktp_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload file</span>
                                        <input id="ktp_image" name="ktp_image" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG sampai 2MB</p>
                            </div>
                        </div>
                        @error('ktp_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('family-members.index') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        Simpan Warga
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const familySelect = document.getElementById('family_id');
    const relationshipSelect = document.getElementById('relationship_to_head');

    function updateRelationshipOptions() {
        const selectedFamily = familySelect.value;

        if (selectedFamily === '') {
            // Jika tidak ada keluarga, hanya tampilkan opsi yang relevan untuk warga independen
            relationshipSelect.innerHTML = `
                <option value="">Pilih Hubungan</option>
                <option value="KEPALA KELUARGA">Kepala Keluarga</option>
                <option value="LAINNYA">Lainnya</option>
            `;

            // Tambahkan class untuk menunjukkan status independen
            document.querySelector('.bg-white').classList.add('border-blue-200');
            document.querySelector('.bg-white').classList.remove('border-gray-200');
        } else {
            // Jika ada keluarga, tampilkan semua opsi
            relationshipSelect.innerHTML = `
                <option value="">Pilih Hubungan</option>
                <option value="KEPALA KELUARGA">Kepala Keluarga</option>
                <option value="SUAMI">Suami</option>
                <option value="ISTRI">Istri</option>
                <option value="ANAK">Anak</option>
                <option value="ORANGTUA">Orang Tua</option>
                <option value="FAMILI LAIN">Famili Lain</option>
                <option value="PEMBANTU">Pembantu</option>
                <option value="LAINNYA">Lainnya</option>
            `;

            // Kembalikan class normal
            document.querySelector('.bg-white').classList.remove('border-blue-200');
            document.querySelector('.bg-white').classList.add('border-gray-200');
        }
    }

    familySelect.addEventListener('change', updateRelationshipOptions);

    // Panggil fungsi saat halaman dimuat
    updateRelationshipOptions();
});
</script>
@endsection
