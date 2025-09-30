@extends('layouts.app')

@section('title', 'Tambah Periode Air - E-Kartu Keluarga')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Tambah Periode Air</h1>
        <a href="{{ route('water-periods.index') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('water-periods.store') }}" class="space-y-6 p-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Nama Periode -->
                <div>
                    <label for="period_name" class="block text-sm font-medium text-gray-700">
                        Nama Periode <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="period_name" id="period_name" value="{{ old('period_name') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('period_name') border-red-300 @enderror"
                           placeholder="Agustus 2025" required>
                    @error('period_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kode Periode -->
                <div>
                    <label for="period_code" class="block text-sm font-medium text-gray-700">
                        Kode Periode <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="period_code" id="period_code" value="{{ old('period_code') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('period_code') border-red-300 @enderror"
                           placeholder="2025-08" maxlength="7" required>
                    @error('period_code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Format: YYYY-MM (contoh: 2025-08)</p>
                </div>

                <!-- Tanggal Jatuh Tempo -->
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700">
                        Tanggal Jatuh Tempo <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('due_date') border-red-300 @enderror"
                           required>
                    @error('due_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga per M3 -->
                <div>
                    <label for="price_per_m3" class="block text-sm font-medium text-gray-700">
                        Harga per M3 <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="price_per_m3" id="price_per_m3" value="{{ old('price_per_m3') }}"
                               class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('price_per_m3') border-red-300 @enderror"
                               placeholder="5000" step="0.01" min="0" required>
                    </div>
                    @error('price_per_m3')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Biaya Administrasi -->
                <div class="sm:col-span-2">
                    <label for="admin_fee" class="block text-sm font-medium text-gray-700">
                        Biaya Administrasi <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="admin_fee" id="admin_fee" value="{{ old('admin_fee', 0) }}"
                               class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('admin_fee') border-red-300 @enderror"
                               placeholder="0" step="0.01" min="0" required>
                    </div>
                    @error('admin_fee')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('water-periods.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-generate period code from period name
document.getElementById('period_name').addEventListener('input', function() {
    const periodName = this.value.toLowerCase();
    const periodCodeInput = document.getElementById('period_code');

    // Simple mapping for common month names
    const monthMap = {
        'januari': '01', 'februari': '02', 'maret': '03', 'april': '04',
        'mei': '05', 'juni': '06', 'juli': '07', 'agustus': '08',
        'september': '09', 'oktober': '10', 'november': '11', 'desember': '12'
    };

    // Extract year and month
    const yearMatch = periodName.match(/(\d{4})/);
    const monthMatch = Object.keys(monthMap).find(month => periodName.includes(month));

    if (yearMatch && monthMatch) {
        const year = yearMatch[1];
        const month = monthMap[monthMatch];
        periodCodeInput.value = `${year}-${month}`;
    }
});
</script>
@endsection
