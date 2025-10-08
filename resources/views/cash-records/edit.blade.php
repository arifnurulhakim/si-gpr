@extends('layouts.app')

@section('title', 'Edit Data Kas - SI-GPR')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Data Kas</h1>
        <a href="{{ route('cash-periods.show', $cashPeriod->id) }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            Kembali
        </a>
    </div>

    <!-- Period Info -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Informasi Periode</h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Periode</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $cashPeriod->period_name }} ({{ $cashPeriod->period_code }})</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Blok</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $cashRecord->residentBlock->block ?? 'N/A' }} - {{ $cashRecord->family->head_of_family_name ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ route('cash-records.update', [$cashPeriod->id, $cashRecord->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
                <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Data Kas Keluarga</h3>
            </div>
            <div class="border-t border-gray-200 px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="block_id" class="block text-sm font-medium text-gray-700">Blok</label>
                        <select name="block_id" id="block_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('block_id') border-red-300 @enderror">
                            <option value="">Pilih Blok</option>
                            @foreach($residentBlocks as $residentBlock)
                                <option value="{{ $residentBlock->id }}" {{ old('block_id', $cashRecord->block_id) == $residentBlock->id ? 'selected' : '' }}>
                                    {{ $residentBlock->block }} - {{ $residentBlock->resident ? $residentBlock->resident->name : 'Blok Kosong' }}
                                </option>
                            @endforeach
                        </select>
                        @error('block_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cash_amount" class="block text-sm font-medium text-gray-700">Uang Kas</label>
                        <input type="number" name="cash_amount" id="cash_amount" value="{{ old('cash_amount', $cashRecord->cash_amount) }}" min="0" step="0.01" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('cash_amount') border-red-300 @enderror">
                        @error('cash_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="patrol_amount" class="block text-sm font-medium text-gray-700">Uang Ronda</label>
                        <input type="number" name="patrol_amount" id="patrol_amount" value="{{ old('patrol_amount', $cashRecord->patrol_amount) }}" min="0" step="0.01" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('patrol_amount') border-red-300 @enderror">
                        @error('patrol_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="other_amount" class="block text-sm font-medium text-gray-700">Lain-lain</label>
                        <input type="number" name="other_amount" id="other_amount" value="{{ old('other_amount', $cashRecord->other_amount) }}" min="0" step="0.01" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('other_amount') border-red-300 @enderror">
                        @error('other_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total Pembayaran</label>
                        <div class="mt-1 p-3 bg-gray-50 border border-gray-300 rounded-md">
                            <span id="total-display" class="text-lg font-medium text-gray-900">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6 bg-gray-50">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('cash-periods.show', $cashPeriod->id) }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Calculate total amount
function calculateTotal() {
    const cashAmount = parseFloat(document.getElementById('cash_amount').value) || 0;
    const patrolAmount = parseFloat(document.getElementById('patrol_amount').value) || 0;
    const otherAmount = parseFloat(document.getElementById('other_amount').value) || 0;
    const adminFee = {{ $cashPeriod->admin_fee }};

    const total = cashAmount + patrolAmount + otherAmount + adminFee;

    // Update total display
    const totalDisplay = document.getElementById('total-display');
    totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// Add event listeners for calculation
document.getElementById('cash_amount').addEventListener('input', calculateTotal);
document.getElementById('patrol_amount').addEventListener('input', calculateTotal);
document.getElementById('other_amount').addEventListener('input', calculateTotal);

// Calculate initial total
calculateTotal();
</script>
@endsection
