<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\FamilyCardRequest;
use App\Models\WaterPeriod;
use App\Models\WaterUsageRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // For admin users, show full dashboard
        if ($user->role === 'admin') {
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
                'recentWaterRecords'
            ));
        }
        
        // For regular users, show only water and cash bills counts
        $userWaterBillsCount = 0;
        $userCashBillsCount = 0;
        
        if ($user->residentBlock) {
            $userWaterBillsCount = $user->residentBlock->waterUsageRecords()->count();
            $userCashBillsCount = $user->residentBlock->cashRecords()->count();
        }

        return view('dashboard', compact(
            'userWaterBillsCount',
            'userCashBillsCount'
        ));
    }
}
