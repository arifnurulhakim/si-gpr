@extends('layouts.app')

@section('title', 'Input Data Air - SI-GPR')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Input Data Air</h1>
        <a href="{{ route('water-periods.show', $waterPeriod->id) }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            Kembali
        </a>
    </div>

    <!-- Info Periode -->
    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Info Periode</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Harga per M3: <strong>Rp {{ number_format($waterPeriod->price_per_m3) }}</strong></p>
                    <p>Biaya Administrasi: <strong>Rp {{ number_format($waterPeriod->admin_fee) }}</strong></p>
                    <p>Jatuh Tempo: <strong>{{ $waterPeriod->due_date->format('d M Y') }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">

        <form method="POST" action="{{ route('water-usage.store', $waterPeriod->id) }}"
              class="space-y-6 p-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Pilih Blok -->
                <div class="sm:col-span-2">
                    <label for="block_id" class="block text-sm font-medium text-gray-700">
                        Pilih Blok <span class="text-red-500">*</span>
                    </label>
                    <select name="block_id" id="block_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('block_id') border-red-300 @enderror" required>
                        <option value="">-- Pilih Blok --</option>
                        @foreach($residentBlocks as $residentBlock)
                            <option value="{{ $residentBlock->id }}" {{ old('block_id') == $residentBlock->id ? 'selected' : '' }}>
                                {{ $residentBlock->block }} - {{ $residentBlock->resident ? $residentBlock->resident->name : 'Blok Kosong' }}
                            </option>
                        @endforeach
                    </select>
                    @error('block_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Meteran Awal -->
                <div>
                    <label for="initial_meter_reading" class="block text-sm font-medium text-gray-700">
                        Meteran Awal <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="number" name="initial_meter_reading" id="initial_meter_reading" value="{{ old('initial_meter_reading') }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('initial_meter_reading') border-red-300 @enderror"
                               placeholder="0.00" step="0.01" min="0" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">M3</span>
                        </div>
                    </div>
                    @error('initial_meter_reading')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Meteran Akhir -->
                <div>
                    <label for="final_meter_reading" class="block text-sm font-medium text-gray-700">
                        Meteran Akhir <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="number" name="final_meter_reading" id="final_meter_reading" value="{{ old('final_meter_reading') }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('final_meter_reading') border-red-300 @enderror"
                               placeholder="0.00" step="0.01" min="0" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">M3</span>
                        </div>
                    </div>
                    @error('final_meter_reading')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Kalkulasi Otomatis -->
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                <h3 class="text-sm font-medium text-gray-900 mb-3">Kalkulasi Otomatis</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Jumlah Pemakaian</label>
                        <p id="usage_amount" class="mt-1 text-sm font-medium text-gray-900">0.00 M3</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Tagihan Air</label>
                        <p id="bill_amount" class="mt-1 text-sm font-medium text-gray-900">Rp 0</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Total Bayar</label>
                        <p id="total_payment" class="mt-1 text-sm font-medium text-gray-900">Rp 0</p>
                    </div>
                </div>
            </div>

            <!-- Foto Meteran Air Referensi -->
            <div id="meter-photos-section" class="bg-blue-50 border border-blue-200 rounded-md p-4 hidden">
                <h3 class="text-sm font-medium text-blue-900 mb-3">Foto Meteran Air Referensi</h3>

                <!-- Grid layout for side-by-side photos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Previous Period Photo -->
                    <div id="previous-period-photo" class="space-y-2 hidden">
                        <h4 class="text-xs font-medium text-blue-800 mb-2">Periode Sebelumnya</h4>
                        <div id="previous-photo-placeholder" class="border-2 border-dashed border-blue-300 rounded-lg p-4 text-center bg-white">
                            <svg class="mx-auto h-8 w-8 text-blue-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-xs text-blue-600">Tidak ada periode sebelumnya</p>
                        </div>
                        <div id="previous-photo-content" class="hidden">
                            <img id="previous-photo-img" src="" alt="Foto Meteran Periode Sebelumnya" class="w-full h-auto rounded-lg shadow-sm cursor-pointer border opacity-75" onclick="openImageModal(this.src)">
                            <p id="previous-photo-info" class="mt-1 text-xs text-blue-700"></p>
                        </div>
                    </div>

                    <!-- Current Period Photo -->
                    <div id="current-period-photo" class="space-y-2">
                        <h4 class="text-xs font-medium text-blue-800 mb-2">Periode Saat Ini: {{ $waterPeriod->period_name }}</h4>
                        <div id="current-photo-placeholder" class="border-2 border-dashed border-blue-300 rounded-lg p-4 text-center bg-white">
                            <svg class="mx-auto h-8 w-8 text-blue-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-xs text-blue-600">Pilih blok untuk melihat foto meteran</p>
                        </div>
                        <div id="current-photo-content" class="hidden">
                            <img id="current-photo-img" src="" alt="Foto Meteran Periode Saat Ini" class="w-full h-auto rounded-lg shadow-sm cursor-pointer border" onclick="openImageModal(this.src)">
                            <p id="current-photo-info" class="mt-1 text-xs text-blue-700"></p>
                        </div>
                    </div>
                </div>

                <div class="mt-3 p-3 bg-blue-100 border border-blue-200 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-2">
                            <p class="text-xs text-blue-800">
                                <strong>Tips:</strong> Gunakan foto meteran sebagai referensi untuk mengisi meteran awal dan akhir dengan akurat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('water-periods.show', $waterPeriod->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
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

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="modalImage" src="" alt="Foto Meteran" class="max-w-full max-h-full rounded-lg shadow-lg">
        </div>
    </div>
</div>

<script>
const pricePerM3 = '{{ $waterPeriod->price_per_m3 }}';
const adminFee = '{{ $waterPeriod->admin_fee }}';
const currentPeriodName = '{{ $waterPeriod->period_name }}';

// Pass meter photos data from PHP to JavaScript
const meterPhotosData = JSON.parse('{!! json_encode($meterPhotosData ?? []) !!}');
console.log('Meter photos data from PHP:', meterPhotosData);

function calculateAmounts() {
    const initialReading = parseFloat(document.getElementById('initial_meter_reading').value) || 0;
    const finalReading = parseFloat(document.getElementById('final_meter_reading').value) || 0;

    const usageAmount = finalReading - initialReading;
    const billAmount = usageAmount * pricePerM3;
    const totalPayment = billAmount + adminFee;

    document.getElementById('usage_amount').textContent = usageAmount.toFixed(2) + ' M3';
    document.getElementById('bill_amount').textContent = 'Rp ' + billAmount.toLocaleString('id-ID');
    document.getElementById('total_payment').textContent = 'Rp ' + totalPayment.toLocaleString('id-ID');
}

// Add event listeners
document.getElementById('initial_meter_reading').addEventListener('input', calculateAmounts);
document.getElementById('final_meter_reading').addEventListener('input', calculateAmounts);
document.getElementById('block_id').addEventListener('change', loadMeterPhotos);

// Initial calculation
calculateAmounts();

// Auto-load photos when page loads if a block is already selected
document.addEventListener('DOMContentLoaded', function() {
    // Make meterPhotosData available globally
    window.meterPhotosData = meterPhotosData;

    const selectedBlockId = document.getElementById('block_id').value;
    if (selectedBlockId) {
        loadMeterPhotos();
    }
});

function loadMeterPhotos() {
    const blockId = document.getElementById('block_id').value;
    const photosSection = document.getElementById('meter-photos-section');

    console.log('Loading meter photos for block ID:', blockId);

    if (!blockId) {
        photosSection.classList.add('hidden');
        return;
    }

    // Show photos section
    photosSection.classList.remove('hidden');

    // Find photos for selected block
    const blockPhotos = window.meterPhotosData[blockId];
    console.log('Block photos data:', blockPhotos);

    if (!blockPhotos) {
        // No photos available - show placeholders in side-by-side layout
        document.getElementById('current-photo-placeholder').classList.remove('hidden');
        document.getElementById('current-photo-content').classList.add('hidden');
        document.getElementById('previous-period-photo').classList.remove('hidden');
        document.getElementById('previous-photo-placeholder').classList.remove('hidden');
        document.getElementById('previous-photo-content').classList.add('hidden');
        return;
    }

    // Load current period photo
    if (blockPhotos.current_period && blockPhotos.current_period.photo_url) {
        console.log('Loading current period photo:', blockPhotos.current_period.photo_url);
        document.getElementById('current-photo-img').src = blockPhotos.current_period.photo_url;
        document.getElementById('current-photo-info').textContent =
            `Diupload: ${blockPhotos.current_period.created_at} oleh ${blockPhotos.current_period.uploaded_by || 'Unknown'}`;
        document.getElementById('current-photo-placeholder').classList.add('hidden');
        document.getElementById('current-photo-content').classList.remove('hidden');
    } else {
        console.log('No current period photo available');
        document.getElementById('current-photo-placeholder').classList.remove('hidden');
        document.getElementById('current-photo-content').classList.add('hidden');
    }

    // Load previous period photo - always show the section in side-by-side layout
    document.getElementById('previous-period-photo').classList.remove('hidden');

    if (blockPhotos.previous_period && blockPhotos.previous_period.photo_url) {
        console.log('Loading previous period photo:', blockPhotos.previous_period.photo_url);
        document.getElementById('previous-photo-img').src = blockPhotos.previous_period.photo_url;
        document.getElementById('previous-photo-info').textContent =
            `Periode: ${blockPhotos.previous_period.period_name} - Diupload: ${blockPhotos.previous_period.created_at}`;
        document.getElementById('previous-photo-placeholder').classList.add('hidden');
        document.getElementById('previous-photo-content').classList.remove('hidden');
    } else {
        console.log('No previous period photo available');
        document.getElementById('previous-photo-placeholder').classList.remove('hidden');
        document.getElementById('previous-photo-content').classList.add('hidden');
    }
}

function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>
@endsection
