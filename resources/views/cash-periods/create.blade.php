@extends('layouts.app')

@section('title', 'Tambah Periode Kas - SI-GPR')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Tambah Periode Kas</h1>
        <a href="{{ route('cash-periods.index') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ route('cash-periods.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
                <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Informasi Periode Kas</h3>
            </div>
            <div class="border-t border-gray-200 px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="period_name" class="block text-sm font-medium text-gray-700">Nama Periode</label>
                        <input type="text" name="period_name" id="period_name" value="{{ old('period_name') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('period_name') border-red-300 @enderror">
                        @error('period_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="period_code" class="block text-sm font-medium text-gray-700">Kode Periode</label>
                        <input type="text" name="period_code" id="period_code" value="{{ old('period_code') }}" placeholder="2025-08" maxlength="7" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('period_code') border-red-300 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Format: YYYY-MM (contoh: 2025-08)</p>
                        @error('period_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700">Tanggal Jatuh Tempo</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('due_date') border-red-300 @enderror">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="admin_fee" class="block text-sm font-medium text-gray-700">Biaya Admin</label>
                        <input type="number" name="admin_fee" id="admin_fee" value="{{ old('admin_fee', 0) }}" min="0" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('admin_fee') border-red-300 @enderror">
                        @error('admin_fee')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
                <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Jumlah Kas</h3>
            </div>
            <div class="border-t border-gray-200 px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div>
                        <label for="cash_amount" class="block text-sm font-medium text-gray-700">Uang Kas</label>
                        <input type="number" name="cash_amount" id="cash_amount" value="{{ old('cash_amount', 0) }}" min="0" step="0.01" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('cash_amount') border-red-300 @enderror">
                        @error('cash_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="patrol_amount" class="block text-sm font-medium text-gray-700">Uang Ronda</label>
                        <input type="number" name="patrol_amount" id="patrol_amount" value="{{ old('patrol_amount', 0) }}" min="0" step="0.01" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('patrol_amount') border-red-300 @enderror">
                        @error('patrol_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="other_amount" class="block text-sm font-medium text-gray-700">Lain-lain</label>
                        <input type="number" name="other_amount" id="other_amount" value="{{ old('other_amount', 0) }}" min="0" step="0.01" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('other_amount') border-red-300 @enderror">
                        @error('other_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6 bg-gray-50">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('cash-periods.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
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
// Auto-format period code
document.getElementById('period_code').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
    if (value.length >= 4) {
        value = value.substring(0, 4) + '-' + value.substring(4, 6);
    }
    e.target.value = value;
});

// Calculate total amount
function calculateTotal() {
    const cashAmount = parseFloat(document.getElementById('cash_amount').value) || 0;
    const patrolAmount = parseFloat(document.getElementById('patrol_amount').value) || 0;
    const otherAmount = parseFloat(document.getElementById('other_amount').value) || 0;
    const adminFee = parseFloat(document.getElementById('admin_fee').value) || 0;

    const total = cashAmount + patrolAmount + otherAmount + adminFee;

    // Update total display if exists
    const totalDisplay = document.getElementById('total-display');
    if (totalDisplay) {
        totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
}

// Add event listeners for calculation
document.getElementById('cash_amount').addEventListener('input', calculateTotal);
document.getElementById('patrol_amount').addEventListener('input', calculateTotal);
document.getElementById('other_amount').addEventListener('input', calculateTotal);
document.getElementById('admin_fee').addEventListener('input', calculateTotal);
</script>
@endsection
