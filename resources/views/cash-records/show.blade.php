@extends('layouts.app')

@section('title', 'Detail Record Kas - E-Kartu Keluarga')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Detail Record Kas</h1>
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
            @if(auth()->user()->isAdmin())
            <a href="{{ route('cash-records.print', [$cashPeriod->id, $cashRecord->id]) }}" target="_blank" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Struk
            </a>
            <a href="{{ route('cash-records.edit', [$cashPeriod->id, $cashRecord->id]) }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 transition-colors">
                Edit
            </a>
            @else
                @if($cashRecord->payment_status === 'LUNAS' && $cashRecord->verified_at)
                <a href="{{ route('my-cash-usage.print', [$cashPeriod->id, $cashRecord->id]) }}" target="_blank" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Struk
                </a>
                @else
                <button disabled class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-400 bg-gray-200 cursor-not-allowed" title="Struk hanya bisa dicetak setelah pembayaran diverifikasi admin">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Struk
                </button>
                @endif
            @endif
            <a href="{{ auth()->user()->isAdmin() ? route('cash-periods.show', $cashPeriod->id) : route('my-cash-bills') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                Kembali
            </a>
        </div>
    </div>

    <!-- Info Record -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Informasi Record Kas</h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Periode</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $cashPeriod->period_name }} ({{ $cashPeriod->period_code }})</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">No. KK</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $cashRecord->family->family_card_number }}</dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kepala Keluarga</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $cashRecord->family->head_of_family_name }}</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Uang Kas</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($cashRecord->cash_amount) }}</dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Uang Ronda</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($cashRecord->patrol_amount) }}</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Lain-lain</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($cashRecord->other_amount) }}</dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Total Pembayaran</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($cashRecord->total_payment) }}</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Status Pembayaran</dt>
                    <dd class="mt-1 sm:mt-0 sm:col-span-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cashRecord->payment_status === 'LUNAS' ? 'bg-green-100 text-green-800' : ($cashRecord->payment_status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : ($cashRecord->payment_status === 'PAYMENT_UPLOADED' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            {{ $cashRecord->payment_status }}
                        </span>
                    </dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Dibuat Oleh</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $cashRecord->recordedBy->name ?? 'Admin' }}</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $cashRecord->created_at->format('d M Y H:i') }}</dd>
                </div>
                @if($cashRecord->verified_at)
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Diverifikasi Oleh</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $cashRecord->verifiedBy->name ?? 'Admin' }}</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Verifikasi</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $cashRecord->verified_at->format('d M Y H:i') }}</dd>
                </div>
                @endif
                @if($cashRecord->rejection_reason)
                <div class="bg-red-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-red-500">Alasan Penolakan</dt>
                    <dd class="mt-1 text-sm text-red-700 sm:mt-0 sm:col-span-2">{{ $cashRecord->rejection_reason }}</dd>
                </div>
                @endif
            </dl>
        </div>
    </div>

    <!-- Payment Proof Section -->
    @if($cashRecord->payment_proof_path)
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Bukti Pembayaran</h3>
        </div>
        <div class="border-t border-gray-200 px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <div class="flex flex-col items-center space-y-4">
                <img src="{{ Storage::url($cashRecord->payment_proof_path) }}"
                     alt="Bukti Pembayaran"
                     class="max-w-full h-auto rounded-lg shadow-sm cursor-pointer"
                     onclick="openImageModal(this.src)">
                <p class="text-sm text-gray-500">Klik gambar untuk memperbesar</p>
                <p class="text-sm text-gray-500">Diupload pada: {{ $cashRecord->payment_proof_uploaded_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Payment Actions -->
    @if(auth()->user()->isUser() && in_array($cashRecord->payment_status, ['PENDING', 'REJECTED']))
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Upload Bukti Pembayaran</h3>
        </div>
        <div class="border-t border-gray-200 px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <form action="{{ route('my-cash-usage.upload-proof', [$cashPeriod->id, $cashRecord->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="payment_proof" class="block text-sm font-medium text-gray-700">Bukti Pembayaran</label>
                    <input type="file" name="payment_proof" id="payment_proof" accept="image/*" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG. Maksimal 2MB</p>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        Upload Bukti
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if(auth()->user()->isAdmin() && $cashRecord->payment_status === 'PAYMENT_UPLOADED')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Verifikasi Pembayaran</h3>
        </div>
        <div class="border-t border-gray-200 px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <form action="{{ route('cash-records.verify', [$cashPeriod->id, $cashRecord->id]) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="action" class="block text-sm font-medium text-gray-700">Tindakan</label>
                    <select name="action" id="action" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Pilih Tindakan</option>
                        <option value="approve">Setujui (LUNAS)</option>
                        <option value="reject">Tolak</option>
                    </select>
                </div>
                <div id="rejection-reason" class="hidden">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="max-w-4xl max-h-full p-4">
        <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full max-h-full object-contain">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Show/hide rejection reason based on action
document.getElementById('action').addEventListener('change', function() {
    const rejectionReason = document.getElementById('rejection-reason');
    if (this.value === 'reject') {
        rejectionReason.classList.remove('hidden');
    } else {
        rejectionReason.classList.add('hidden');
    }
});

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>
@endsection
