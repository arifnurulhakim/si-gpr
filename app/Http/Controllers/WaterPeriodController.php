<?php

namespace App\Http\Controllers;

use App\Models\WaterPeriod;
use App\Models\WaterUsageRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaterPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'period_code');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = WaterPeriod::withCount('waterUsageRecords');

        // Apply sorting
        if (in_array($sortBy, ['period_name', 'period_code', 'due_date', 'price_per_m3', 'status', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('period_code', 'desc');
        }

        $periods = $query->paginate($perPage);
        $periods->appends($request->query());

        return view('water-periods.index', compact('periods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('water-periods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'period_name' => 'required|string|max:255',
            'period_code' => 'required|string|max:7|unique:water_periods',
            'due_date' => 'required|date',
            'price_per_m3' => 'required|numeric|min:0',
            'admin_fee' => 'required|numeric|min:0',
        ]);

        WaterPeriod::create([
            'period_name' => $request->period_name,
            'period_code' => $request->period_code,
            'due_date' => $request->due_date,
            'price_per_m3' => $request->price_per_m3,
            'admin_fee' => $request->admin_fee,
            'status' => 'ACTIVE',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('water-periods.index')->with('success', 'Periode air berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $period = WaterPeriod::findOrFail($id);

        // Get water usage records with pagination and sorting
        $query = $period->waterUsageRecords()->with('family');

        // Apply sorting
        if (in_array($sortBy, ['usage_amount', 'bill_amount', 'total_payment', 'payment_status', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $records = $query->paginate($perPage);
        $records->appends($request->query());

        return view('water-periods.show', compact('period', 'records'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $period = WaterPeriod::findOrFail($id);
        return view('water-periods.edit', compact('period'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $period = WaterPeriod::findOrFail($id);

        $request->validate([
            'period_name' => 'required|string|max:255',
            'period_code' => 'required|string|max:7|unique:water_periods,period_code,' . $id,
            'due_date' => 'required|date',
            'price_per_m3' => 'required|numeric|min:0',
            'admin_fee' => 'required|numeric|min:0',
            'status' => 'required|in:ACTIVE,CLOSED,ARCHIVED',
        ]);

        $period->update($request->all());

        return redirect()->route('water-periods.index')->with('success', 'Periode air berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $period = WaterPeriod::findOrFail($id);

        // Check if period has usage records
        if ($period->waterUsageRecords()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus periode yang sudah memiliki data penggunaan air');
        }

        $period->delete();

        return redirect()->route('water-periods.index')->with('success', 'Periode air berhasil dihapus');
    }

    /**
     * Close the period
     */
    public function close(string $id)
    {
        $period = WaterPeriod::findOrFail($id);
        $period->update(['status' => 'CLOSED']);

        return redirect()->back()->with('success', 'Periode berhasil ditutup');
    }

    /**
     * Permanently delete the period and all related records
     */
    public function forceDelete(string $id)
    {
        $period = WaterPeriod::findOrFail($id);

        // Delete all related water usage records and their payment proofs
        foreach ($period->waterUsageRecords as $record) {
            // Delete payment proof file if exists
            if ($record->payment_proof_path) {
                \Storage::disk('public')->delete($record->payment_proof_path);
            }
            $record->delete();
        }

        // Delete the period
        $period->delete();

        return redirect()->route('water-periods.index')->with('success', 'Periode air dan semua data terkait berhasil dihapus permanen');
    }
}
