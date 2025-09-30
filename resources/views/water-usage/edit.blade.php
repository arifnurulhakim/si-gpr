@extends('layouts.app')

@section('title', 'Edit Data Air - E-Kartu Keluarga')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Data Air</h1>
        <a href="{{ route('water-usage.show', [$waterPeriod->id, $waterUsageRecord->id]) }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
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
        <form method="POST" action="{{ route('water-usage.update', [$waterPeriod->id, $waterUsageRecord->id]) }}" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Pilih Keluarga -->
                <div class="sm:col-span-2">
                    <label for="family_id" class="block text-sm font-medium text-gray-700">
                        Pilih Keluarga <span class="text-red-500">*</span>
                    </label>
                    <select name="family_id" id="family_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('family_id') border-red-300 @enderror" required>
                        <option value="">-- Pilih Keluarga --</option>
                        @foreach($families as $family)
                            <option value="{{ $family->id }}" {{ old('family_id', $waterUsageRecord->family_id) == $family->id ? 'selected' : '' }}>
                                {{ $family->family_card_number }} - {{ $family->head_of_family_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('family_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Meteran Awal -->
                <div>
                    <label for="initial_meter_reading" class="block text-sm font-medium text-gray-700">
                        Meteran Awal <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="number" name="initial_meter_reading" id="initial_meter_reading" value="{{ old('initial_meter_reading', $waterUsageRecord->initial_meter_reading) }}"
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
                        <input type="number" name="final_meter_reading" id="final_meter_reading" value="{{ old('final_meter_reading', $waterUsageRecord->final_meter_reading) }}"
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
                        <p id="usage_amount" class="mt-1 text-sm font-medium text-gray-900">{{ number_format($waterUsageRecord->usage_amount, 2) }} M3</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Tagihan Air</label>
                        <p id="bill_amount" class="mt-1 text-sm font-medium text-gray-900">Rp {{ number_format($waterUsageRecord->bill_amount) }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Total Bayar</label>
                        <p id="total_payment" class="mt-1 text-sm font-medium text-gray-900">Rp {{ number_format($waterUsageRecord->total_payment) }}</p>
                    </div>
                </div>
            </div>

            <!-- Info Status Pembayaran -->
            @if($waterUsageRecord->payment_status !== 'PENDING')
            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Status pembayaran saat ini: <strong>{{ $waterUsageRecord->payment_status }}</strong></p>
                            <p>Mengubah data meteran akan mempengaruhi perhitungan tagihan. Pastikan data yang diinput sudah benar.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('water-usage.show', [$waterPeriod->id, $waterUsageRecord->id]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const pricePerM3 = {{ $waterPeriod->price_per_m3 }};
const adminFee = {{ $waterPeriod->admin_fee }};

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

// Initial calculation
calculateAmounts();
</script>
@endsection
