<?php

namespace App\Http\Controllers;

use App\Models\WaterPeriod;
use App\Models\WaterUsageRecord;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class WaterUsageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = WaterUsageRecord::with(['family', 'residentBlock', 'waterPeriod']);

        // Apply sorting
        if (in_array($sortBy, ['usage_amount', 'bill_amount', 'total_payment', 'payment_status', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $records = $query->paginate($perPage);
        $records->appends($request->query());

        return view('water-usage.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(WaterPeriod $waterPeriod)
    {
        $residentBlocks = \App\Models\ResidentBlock::with(['family', 'resident'])->orderBy('block')->get();

        // Get previous period for reference
        $previousPeriod = WaterPeriod::where('status', 'ACTIVE')
            ->where('id', '!=', $waterPeriod->id)
            ->orderBy('due_date', 'desc')
            ->first();

        // Prepare meter photos data
        $meterPhotosData = [];
        foreach ($residentBlocks as $block) {
            $blockPhotos = [
                'current_period' => null,
                'previous_period' => null
            ];

            // Get current period photo
            $currentPhoto = $block->waterMeterPhotos()
                ->where('water_period_id', $waterPeriod->id)
                ->with('uploadedBy')
                ->first();

            if ($currentPhoto) {
                $blockPhotos['current_period'] = [
                    'photo_url' => $currentPhoto->photo_url,
                    'created_at' => $currentPhoto->created_at->format('d M Y H:i'),
                    'uploaded_by' => $currentPhoto->uploadedBy->name ?? 'Unknown'
                ];
            }

            // Get previous period photo
            if ($previousPeriod) {
                $previousPhoto = $block->waterMeterPhotos()
                    ->where('water_period_id', $previousPeriod->id)
                    ->with('uploadedBy')
                    ->first();

                if ($previousPhoto) {
                    $blockPhotos['previous_period'] = [
                        'photo_url' => $previousPhoto->photo_url,
                        'period_name' => $previousPeriod->period_name,
                        'created_at' => $previousPhoto->created_at->format('d M Y H:i'),
                        'uploaded_by' => $previousPhoto->uploadedBy->name ?? 'Unknown'
                    ];
                }
            }

            $meterPhotosData[$block->id] = $blockPhotos;
        }

        return view('water-usage.create', compact('waterPeriod', 'residentBlocks', 'meterPhotosData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, WaterPeriod $waterPeriod)
    {
        $request->validate([
            'block_id' => 'required|exists:resident_blocks,id',
            'initial_meter_reading' => 'required|numeric|min:0',
            'final_meter_reading' => 'required|numeric|min:0|gt:initial_meter_reading',
        ]);

        $usageAmount = $request->final_meter_reading - $request->initial_meter_reading;
        $billAmount = $usageAmount * $waterPeriod->price_per_m3;
        $totalPayment = $billAmount + $waterPeriod->admin_fee;

        // Get resident block for reference
        $residentBlock = \App\Models\ResidentBlock::findOrFail($request->block_id);

        WaterUsageRecord::create([
            'family_id' => $residentBlock->family_id, // Keep for reference, can be null
            'block_id' => $request->block_id,
            'water_period_id' => $waterPeriod->id,
            'initial_meter_reading' => $request->initial_meter_reading,
            'final_meter_reading' => $request->final_meter_reading,
            'usage_amount' => $usageAmount,
            'bill_amount' => $billAmount,
            'total_payment' => $totalPayment,
            'payment_status' => 'PENDING',
            'recorded_by' => Auth::id(),
            'recorded_at' => now(),
        ]);

        return redirect()->route('water-periods.show', $waterPeriod->id)
            ->with('success', 'Data penggunaan air berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(WaterPeriod $waterPeriod, WaterUsageRecord $waterUsageRecord)
    {
        $waterUsageRecord->load(['family', 'waterPeriod', 'recordedBy', 'verifiedBy']);
        return view('water-usage.show', compact('waterPeriod', 'waterUsageRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WaterPeriod $waterPeriod, WaterUsageRecord $waterUsageRecord)
    {
        $residentBlocks = \App\Models\ResidentBlock::with(['family', 'resident'])->orderBy('block')->get();
        return view('water-usage.edit', compact('waterPeriod', 'waterUsageRecord', 'residentBlocks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WaterPeriod $waterPeriod, WaterUsageRecord $waterUsageRecord)
    {
        $request->validate([
            'block_id' => 'required|exists:resident_blocks,id',
            'initial_meter_reading' => 'required|numeric|min:0',
            'final_meter_reading' => 'required|numeric|min:0|gt:initial_meter_reading',
        ]);

        $usageAmount = $request->final_meter_reading - $request->initial_meter_reading;
        $billAmount = $usageAmount * $waterPeriod->price_per_m3;
        $totalPayment = $billAmount + $waterPeriod->admin_fee;

        // Get resident block for reference
        $residentBlock = \App\Models\ResidentBlock::findOrFail($request->block_id);

        $waterUsageRecord->update([
            'family_id' => $residentBlock->family_id, // Keep for reference, can be null
            'block_id' => $request->block_id,
            'initial_meter_reading' => $request->initial_meter_reading,
            'final_meter_reading' => $request->final_meter_reading,
            'usage_amount' => $usageAmount,
            'bill_amount' => $billAmount,
            'total_payment' => $totalPayment,
        ]);

        return redirect()->route('water-periods.show', $waterPeriod->id)
            ->with('success', 'Data penggunaan air berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WaterPeriod $waterPeriod, WaterUsageRecord $waterUsageRecord)
    {
        // Delete payment proof if exists
        if ($waterUsageRecord->payment_proof_path) {
            Storage::disk('public')->delete($waterUsageRecord->payment_proof_path);
        }

        $waterUsageRecord->delete();

        return redirect()->route('water-periods.show', $waterPeriod->id)
            ->with('success', 'Data penggunaan air berhasil dihapus');
    }

    /**
     * Upload payment proof
     */
    public function uploadPaymentProof(Request $request, WaterPeriod $waterPeriod, WaterUsageRecord $waterUsageRecord)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Delete old payment proof if exists
        if ($waterUsageRecord->payment_proof_path) {
            Storage::disk('public')->delete($waterUsageRecord->payment_proof_path);
        }

        // Handle file upload
        $image = $request->file('payment_proof');
        $familyCardNumber = $waterUsageRecord->family ? $waterUsageRecord->family->family_card_number : 'BLOCK-' . $waterUsageRecord->block_id;
        $imageName = time() . '_' . $familyCardNumber . '_' . $waterPeriod->period_code . '.' . $image->getClientOriginalExtension();

        // Store file using public disk explicitly
        $imagePath = Storage::disk('public')->putFileAs('payment-proofs', $image, $imageName);

        $waterUsageRecord->update([
            'payment_proof_path' => 'payment-proofs/' . $imageName,
            'payment_proof_uploaded_at' => now(),
            'payment_status' => 'PAYMENT_UPLOADED',
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload');
    }

    /**
     * Verify payment (Admin only)
     */
    public function verifyPayment(Request $request, WaterPeriod $waterPeriod, WaterUsageRecord $waterUsageRecord)
    {
        $request->validate([
            'status' => 'required|in:LUNAS,REJECTED',
            'rejection_reason' => 'required_if:status,REJECTED|nullable|string',
        ]);

        $data = [
            'payment_status' => $request->status,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ];

        if ($request->status === 'REJECTED') {
            $data['rejection_reason'] = $request->rejection_reason;
        }

        $waterUsageRecord->update($data);

        $statusText = $request->status === 'LUNAS' ? 'diverifikasi' : 'ditolak';
        return redirect()->back()->with('success', "Pembayaran berhasil {$statusText}");
    }

    /**
     * Show user's water bills
     */
    public function myWaterBills(Request $request)
    {
        $user = Auth::user();
        $residentBlock = $user->residentBlock;

        if (!$residentBlock) {
            return redirect()->route('dashboard')->with('error', 'Data blok tidak ditemukan');
        }

        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = $residentBlock->waterUsageRecords()->with('waterPeriod');

        // Apply sorting
        if (in_array($sortBy, ['usage_amount', 'bill_amount', 'total_payment', 'payment_status', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $records = $query->paginate($perPage);
        $records->appends($request->query());

        return view('water-usage.my-bills', compact('records', 'residentBlock'));
    }

    /**
     * Clean up orphaned payment proof records
     */
    public function cleanupOrphanedPaymentProofs()
    {
        $orphanedRecords = WaterUsageRecord::whereNotNull('payment_proof_path')
            ->get()
            ->filter(function ($record) {
                return !Storage::disk('public')->exists($record->payment_proof_path);
            });

        $cleanedCount = 0;
        foreach ($orphanedRecords as $record) {
            $record->update([
                'payment_proof_path' => null,
                'payment_proof_uploaded_at' => null,
                'payment_status' => 'PENDING'
            ]);
            $cleanedCount++;
        }

        return response()->json([
            'message' => "Cleaned up {$cleanedCount} orphaned payment proof records",
            'cleaned_count' => $cleanedCount
        ]);
    }

    /**
     * Print water bill receipt
     */
    public function printReceipt(WaterPeriod $waterPeriod, WaterUsageRecord $waterUsageRecord)
    {
        $waterUsageRecord->load(['family', 'waterPeriod', 'recordedBy', 'verifiedBy']);

        return view('water-usage.print-receipt', compact('waterPeriod', 'waterUsageRecord'));
    }
}
