<?php

namespace App\Http\Controllers;

use App\Models\CashPeriod;
use App\Models\CashRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = CashPeriod::with('createdBy');

        // Apply sorting
        if (in_array($sortBy, ['period_name', 'period_code', 'due_date', 'status', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $periods = $query->paginate($perPage);
        $periods->appends($request->query());

        return view('cash-periods.index', compact('periods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cash-periods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'period_name' => 'required|string|max:255',
            'period_code' => 'required|string|size:7|unique:cash_periods,period_code',
            'due_date' => 'required|date',
            'cash_amount' => 'required|numeric|min:0',
            'patrol_amount' => 'required|numeric|min:0',
            'other_amount' => 'required|numeric|min:0',
            'admin_fee' => 'nullable|numeric|min:0',
        ]);

        CashPeriod::create([
            'period_name' => $request->period_name,
            'period_code' => $request->period_code,
            'due_date' => $request->due_date,
            'cash_amount' => $request->cash_amount,
            'patrol_amount' => $request->patrol_amount,
            'other_amount' => $request->other_amount,
            'admin_fee' => $request->admin_fee ?? 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('cash-periods.index')
            ->with('success', 'Periode kas berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $period = CashPeriod::with('createdBy')->findOrFail($id);

        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = $period->cashRecords()->with(['family', 'residentBlock.resident', 'recordedBy', 'verifiedBy']);

        // Apply sorting
        if (in_array($sortBy, ['total_payment', 'payment_status', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $records = $query->paginate($perPage);
        $records->appends($request->query());

        return view('cash-periods.show', compact('period', 'records'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $period = CashPeriod::findOrFail($id);
        return view('cash-periods.edit', compact('period'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $period = CashPeriod::findOrFail($id);

        $request->validate([
            'period_name' => 'required|string|max:255',
            'period_code' => 'required|string|size:7|unique:cash_periods,period_code,' . $id,
            'due_date' => 'required|date',
            'cash_amount' => 'required|numeric|min:0',
            'patrol_amount' => 'required|numeric|min:0',
            'other_amount' => 'required|numeric|min:0',
            'admin_fee' => 'nullable|numeric|min:0',
        ]);

        $period->update([
            'period_name' => $request->period_name,
            'period_code' => $request->period_code,
            'due_date' => $request->due_date,
            'cash_amount' => $request->cash_amount,
            'patrol_amount' => $request->patrol_amount,
            'other_amount' => $request->other_amount,
            'admin_fee' => $request->admin_fee ?? 0,
        ]);

        return redirect()->route('cash-periods.show', $period->id)
            ->with('success', 'Periode kas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $period = CashPeriod::findOrFail($id);

        // Check if period has records
        if ($period->cashRecords()->count() > 0) {
            return redirect()->route('cash-periods.index')
                ->with('error', 'Tidak dapat menghapus periode yang sudah memiliki record kas');
        }

        $period->delete();

        return redirect()->route('cash-periods.index')
            ->with('success', 'Periode kas berhasil dihapus');
    }

    /**
     * Close the period
     */
    public function close(string $id)
    {
        $period = CashPeriod::findOrFail($id);

        $period->update(['status' => 'CLOSED']);

        return redirect()->route('cash-periods.show', $period->id)
            ->with('success', 'Periode kas berhasil ditutup');
    }

    /**
     * Permanently delete the period and all related records
     */
    public function forceDelete(string $id)
    {
        $period = CashPeriod::findOrFail($id);

        // Delete all related cash records and their payment proofs
        foreach ($period->cashRecords as $record) {
            // Delete payment proof file if exists
            if ($record->payment_proof_path) {
                \Storage::disk('public')->delete($record->payment_proof_path);
            }
            $record->delete();
        }

        // Delete the period
        $period->delete();

        return redirect()->route('cash-periods.index')->with('success', 'Periode kas dan semua data terkait berhasil dihapus permanen');
    }
}
