<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\FamilyCardRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFamilies = Family::count();
        $totalMembers = FamilyMember::count();
        $pendingRequests = FamilyCardRequest::where('status', 'PENDING')->count();
        $recentFamilies = Family::latest()->take(5)->get();

        return view('dashboard', compact('totalFamilies', 'totalMembers', 'pendingRequests', 'recentFamilies'));
    }
}
