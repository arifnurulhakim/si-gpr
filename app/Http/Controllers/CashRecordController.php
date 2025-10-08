<?php

namespace App\Http\Controllers;

use App\Models\CashPeriod;
use App\Models\CashRecord;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CashRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = CashRecord::with(['family', 'residentBlock', 'cashPeriod']);

        // Apply sorting
        if (in_array($sortBy, ['total_payment', 'payment_status', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $records = $query->paginate($perPage);
        $records->appends($request->query());

        return view('cash-records.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CashPeriod $cashPeriod)
    {
        $residentBlocks = \App\Models\ResidentBlock::with(['family', 'resident'])->orderBy('block')->get();
        return view('cash-records.create', compact('cashPeriod', 'residentBlocks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CashPeriod $cashPeriod)
    {
        $request->validate([
            'block_id' => 'required|exists:resident_blocks,id',
            'cash_amount' => 'required|numeric|min:0',
            'patrol_amount' => 'required|numeric|min:0',
            'other_amount' => 'required|numeric|min:0',
        ]);

        $totalPayment = $request->cash_amount + $request->patrol_amount + $request->other_amount + $cashPeriod->admin_fee;

        // Get resident block for reference
        $residentBlock = \App\Models\ResidentBlock::findOrFail($request->block_id);

        CashRecord::create([
            'family_id' => $residentBlock->family_id, // Keep for reference, can be null
            'block_id' => $request->block_id,
            'cash_period_id' => $cashPeriod->id,
            'cash_amount' => $request->cash_amount,
            'patrol_amount' => $request->patrol_amount,
            'other_amount' => $request->other_amount,
            'total_payment' => $totalPayment,
            'payment_status' => 'PENDING',
            'recorded_by' => Auth::id(),
            'recorded_at' => now(),
        ]);

        return redirect()->route('cash-periods.show', $cashPeriod->id)
            ->with('success', 'Data kas berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(CashPeriod $cashPeriod, CashRecord $cashRecord)
    {
        $cashRecord->load(['family', 'cashPeriod', 'recordedBy', 'verifiedBy']);
        return view('cash-records.show', compact('cashPeriod', 'cashRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CashPeriod $cashPeriod, CashRecord $cashRecord)
    {
        $residentBlocks = \App\Models\ResidentBlock::with(['family', 'resident'])->orderBy('block')->get();
        return view('cash-records.edit', compact('cashPeriod', 'cashRecord', 'residentBlocks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CashPeriod $cashPeriod, CashRecord $cashRecord)
    {
        $request->validate([
            'block_id' => 'required|exists:resident_blocks,id',
            'cash_amount' => 'required|numeric|min:0',
            'patrol_amount' => 'required|numeric|min:0',
            'other_amount' => 'required|numeric|min:0',
        ]);

        $totalPayment = $request->cash_amount + $request->patrol_amount + $request->other_amount + $cashPeriod->admin_fee;

        // Get resident block for reference
        $residentBlock = \App\Models\ResidentBlock::findOrFail($request->block_id);

        $cashRecord->update([
            'family_id' => $residentBlock->family_id, // Keep for reference, can be null
            'block_id' => $request->block_id,
            'cash_amount' => $request->cash_amount,
            'patrol_amount' => $request->patrol_amount,
            'other_amount' => $request->other_amount,
            'total_payment' => $totalPayment,
        ]);

        return redirect()->route('cash-periods.show', $cashPeriod->id)
            ->with('success', 'Data kas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CashPeriod $cashPeriod, CashRecord $cashRecord)
    {
        // Delete payment proof if exists
        if ($cashRecord->payment_proof_path) {
            Storage::disk('public')->delete($cashRecord->payment_proof_path);
        }

        $cashRecord->delete();

        return redirect()->route('cash-periods.show', $cashPeriod->id)
            ->with('success', 'Data kas berhasil dihapus');
    }

    /**
     * Upload payment proof
     */
    public function uploadPaymentProof(Request $request, CashPeriod $cashPeriod, CashRecord $cashRecord)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Delete old payment proof if exists
        if ($cashRecord->payment_proof_path) {
            Storage::disk('public')->delete($cashRecord->payment_proof_path);
        }

        // Handle file upload
        $image = $request->file('payment_proof');
        $familyCardNumber = $cashRecord->family ? $cashRecord->family->family_card_number : 'BLOCK-' . $cashRecord->block_id;
        $imageName = time() . '_' . $familyCardNumber . '_' . $cashPeriod->period_code . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('payment-proofs', $imageName, 'public');

        $cashRecord->update([
            'payment_proof_path' => 'payment-proofs/' . $imageName,
            'payment_proof_uploaded_at' => now(),
            'payment_status' => 'PAYMENT_UPLOADED',
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload');
    }

    /**
     * Verify payment
     */
    public function verifyPayment(Request $request, CashPeriod $cashPeriod, CashRecord $cashRecord)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'rejection_reason' => 'required_if:action,reject|string|max:500',
        ]);

        if ($request->action === 'approve') {
            $cashRecord->update([
                'payment_status' => 'LUNAS',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'rejection_reason' => null,
            ]);

            return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi');
        } else {
            $cashRecord->update([
                'payment_status' => 'REJECTED',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'rejection_reason' => $request->rejection_reason,
            ]);

            return redirect()->back()->with('success', 'Pembayaran ditolak');
        }
    }

    /**
     * Show user's cash bills
     */
    public function myCashBills(Request $request)
    {
        $user = Auth::user();
        $residentBlock = $user->residentBlock;

        if (!$residentBlock) {
            return redirect()->route('dashboard')->with('error', 'Data blok tidak ditemukan');
        }

        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = $residentBlock->cashRecords()->with('cashPeriod');

        // Apply sorting
        if (in_array($sortBy, ['total_payment', 'payment_status', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $records = $query->paginate($perPage);
        $records->appends($request->query());

        return view('cash-records.my-bills', compact('records', 'residentBlock'));
    }

    /**
     * Print cash bill receipt
     */
    public function printReceipt(CashPeriod $cashPeriod, CashRecord $cashRecord)
    {
        $cashRecord->load(['family', 'cashPeriod', 'recordedBy', 'verifiedBy']);

        return view('cash-records.print-receipt', compact('cashPeriod', 'cashRecord'));
    }
}
