@extends('layouts.app')

@section('title', 'Detail Record Air - SI-GPR')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Detail Record Air</h1>
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
            @if(auth()->user()->isAdmin())
            <a href="{{ route('water-usage.print', [$waterPeriod->id, $waterUsageRecord->id]) }}" target="_blank" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Struk
            </a>
            <a href="{{ route('water-usage.edit', [$waterPeriod->id, $waterUsageRecord->id]) }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 transition-colors">
                Edit
            </a>
            @else
                @if($waterUsageRecord->payment_status === 'LUNAS' && $waterUsageRecord->verified_at)
                <a href="{{ route('my-water-usage.print', [$waterPeriod->id, $waterUsageRecord->id]) }}" target="_blank" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
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
            <a href="{{ auth()->user()->isAdmin() ? route('water-periods.show', $waterPeriod->id) : route('my-water-bills') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                Kembali
            </a>
        </div>
    </div>

    <!-- Info Record -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Informasi Record Air</h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Periode</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $waterPeriod->period_name }} ({{ $waterPeriod->period_code }})</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">No. KK</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $waterUsageRecord->family ? $waterUsageRecord->family->family_card_number : 'Blok ' . $waterUsageRecord->residentBlock->block }}</dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kepala Keluarga</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $waterUsageRecord->family ? $waterUsageRecord->family->head_of_family_name : 'N/A' }}</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Meteran Awal</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ number_format($waterUsageRecord->initial_meter_reading, 2) }} M3</dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Meteran Akhir</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ number_format($waterUsageRecord->final_meter_reading, 2) }} M3</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Jumlah Pemakaian</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ number_format($waterUsageRecord->usage_amount, 2) }} M3</dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Harga per M3</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($waterPeriod->price_per_m3) }}</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Tagihan Air</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($waterUsageRecord->bill_amount) }}</dd>
                </div>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Biaya Administrasi</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($waterPeriod->admin_fee) }}</dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Total Bayar</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($waterUsageRecord->total_payment) }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        <!-- Status Pembayaran -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
                <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Status Pembayaran</h3>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $waterUsageRecord->payment_status === 'LUNAS' ? 'bg-green-100 text-green-800' : ($waterUsageRecord->payment_status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : ($waterUsageRecord->payment_status === 'PAYMENT_UPLOADED' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                {{ $waterUsageRecord->payment_status }}
                            </span>
                        </dd>
                    </div>

                    @if($waterUsageRecord->payment_proof_path)
                    <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Bukti Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if($waterUsageRecord->hasPaymentProofFile())
                                <div class="mt-2">
                                    <img src="{{ $waterUsageRecord->payment_proof_url }}"
                                         alt="Bukti Pembayaran"
                                         class="max-w-full h-auto rounded-lg shadow-sm cursor-pointer"
                                         onclick="openImageModal(this.src)">
                                </div>
                            @else
                                <div class="mt-2 p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        <span class="text-sm text-red-600">File bukti pembayaran tidak ditemukan</span>
                                    </div>
                                    <p class="mt-1 text-xs text-red-500">File: {{ $waterUsageRecord->payment_proof_path }}</p>
                                </div>
                            @endif
                            @if($waterUsageRecord->payment_proof_uploaded_at)
                            <p class="mt-1 text-xs text-gray-500">Diupload: {{ $waterUsageRecord->payment_proof_uploaded_at->format('d M Y H:i') }}</p>
                            @endif
                        </dd>
                    </div>
                    @endif

                    @if($waterUsageRecord->verified_by)
                    <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Diverifikasi Oleh</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $waterUsageRecord->verifiedBy->name }}
                            @if($waterUsageRecord->verified_at)
                            <p class="text-xs text-gray-500">{{ $waterUsageRecord->verified_at->format('d M Y H:i') }}</p>
                            @endif
                        </dd>
                    </div>
                    @endif

                    @if($waterUsageRecord->rejection_reason)
                    <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Alasan Ditolak</dt>
                        <dd class="mt-1 text-sm text-red-600 sm:mt-0 sm:col-span-2">{{ $waterUsageRecord->rejection_reason }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            <!-- Upload Bukti Pembayaran (untuk user) -->
            @if(auth()->user()->isUser() && in_array($waterUsageRecord->payment_status, ['PENDING', 'REJECTED']))
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
                <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
                    <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Upload Bukti Pembayaran</h3>
                </div>
                <div class="border-t border-gray-200 px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
                    <form action="{{ route('my-water-usage.upload-proof', [$waterPeriod->id, $waterUsageRecord->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="payment_proof" class="block text-sm font-medium text-gray-700">File Bukti Pembayaran</label>
                                <input type="file" name="payment_proof" id="payment_proof" accept="image/*" required
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Upload Bukti
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Verifikasi Pembayaran (untuk admin) -->
            @if(auth()->user()->isAdmin() && $waterUsageRecord->payment_status === 'PAYMENT_UPLOADED')
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
                <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
                    <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Verifikasi Pembayaran</h3>
                </div>
                <div class="border-t border-gray-200 px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
                    <form action="{{ route('water-usage.verify', [$waterPeriod->id, $waterUsageRecord->id]) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Status Verifikasi</label>
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="LUNAS" class="form-radio h-4 w-4 text-green-600">
                                        <span class="ml-2 text-sm text-gray-700">Lunas</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="REJECTED" class="form-radio h-4 w-4 text-red-600">
                                        <span class="ml-2 text-sm text-gray-700">Tolak</span>
                                    </label>
                                </div>
                            </div>
                            <div id="rejection-reason" class="hidden">
                                <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                                <textarea name="rejection_reason" id="rejection_reason" rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                          placeholder="Masukkan alasan penolakan..."></textarea>
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Verifikasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Info Tambahan -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-3 py-4 sm:px-4 sm:py-5 sm:px-6">
            <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Info Tambahan</h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Dibuat Oleh</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $waterUsageRecord->recordedBy->name }}
                        @if($waterUsageRecord->recorded_at)
                        <p class="text-xs text-gray-500">{{ $waterUsageRecord->recorded_at->format('d M Y H:i') }}</p>
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-3 py-4 sm:px-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $waterUsageRecord->updated_at->format('d M Y H:i') }}</dd>
                </div>
            </dl>
        </div>
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
            <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full max-h-full rounded-lg shadow-lg">
        </div>
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

// Show/hide rejection reason based on radio selection
document.addEventListener('DOMContentLoaded', function() {
    const statusRadios = document.querySelectorAll('input[name="status"]');
    const rejectionReason = document.getElementById('rejection-reason');

    statusRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'REJECTED') {
                rejectionReason.classList.remove('hidden');
            } else {
                rejectionReason.classList.add('hidden');
            }
        });
    });
});

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>
@endsection
