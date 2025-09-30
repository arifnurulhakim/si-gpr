<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\FamilyCardRequest;
use App\Models\WaterPeriod;
use App\Models\WaterUsageRecord;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFamilies = Family::count();
        $totalMembers = FamilyMember::count();
        $pendingRequests = FamilyCardRequest::where('status', 'PENDING')->count();
        $recentFamilies = Family::latest()->take(5)->get();

        // Water usage statistics
        $totalWaterPeriods = WaterPeriod::count();
        $activeWaterPeriods = WaterPeriod::where('status', 'ACTIVE')->count();
        $totalWaterRecords = WaterUsageRecord::count();
        $pendingWaterPayments = WaterUsageRecord::whereIn('payment_status', ['PENDING', 'OVERDUE'])->count();
        $paidWaterPayments = WaterUsageRecord::where('payment_status', 'LUNAS')->count();
        $recentWaterRecords = WaterUsageRecord::with(['family', 'waterPeriod'])->latest()->take(5)->get();

        // User-specific data
        $userWaterBills = null;
        $userPendingBills = null;
        $userOverdueBills = null;

        if (auth()->user()->isUser() && auth()->user()->family) {
            $userWaterBills = auth()->user()->family->waterUsageRecords()->count();
            $userPendingBills = auth()->user()->family->waterUsageRecords()->where('payment_status', 'PENDING')->count();
            $userOverdueBills = auth()->user()->family->waterUsageRecords()->where('payment_status', 'OVERDUE')->count();
        }

        return view('dashboard', compact(
            'totalFamilies',
            'totalMembers',
            'pendingRequests',
            'recentFamilies',
            'totalWaterPeriods',
            'activeWaterPeriods',
            'totalWaterRecords',
            'pendingWaterPayments',
            'paidWaterPayments',
            'recentWaterRecords',
            'userWaterBills',
            'userPendingBills',
            'userOverdueBills'
        ));
    }
}
