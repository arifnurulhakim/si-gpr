<?php

namespace App\Http\Controllers;

use App\Models\ResidentBlock;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResidentBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'block');
        $sortOrder = $request->get('sort_order', 'asc');
        $search = $request->get('search', '');

        $query = ResidentBlock::with('resident');

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('block', 'like', "%{$search}%")
                  ->orWhereHas('resident', function($residentQuery) use ($search) {
                      $residentQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }

        // Apply sorting
        if (in_array($sortBy, ['block', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('block', 'asc');
        }

        $residentBlocks = $query->paginate($perPage);
        $residentBlocks->appends($request->query());

        // Get unique blocks for filter
        $uniqueBlocks = ResidentBlock::getUniqueBlocks();

        return view('resident-blocks.index', compact('residentBlocks', 'uniqueBlocks', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get residents that don't have a block assignment yet
        $availableResidents = FamilyMember::whereDoesntHave('residentBlock')->get();

        return view('resident-blocks.create', compact('availableResidents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'block' => 'required|string|max:10|unique:resident_blocks,block',
            'resident_id' => 'required|exists:family_members,id|unique:resident_blocks,resident_id',
        ]);

        // Validate block format
        if (!ResidentBlock::isValidBlockFormat($request->block)) {
            return back()->withErrors(['block' => 'Format blok tidak valid. Gunakan format seperti D1-12 atau D1-12A']);
        }

        // Check if resident already has a block
        $existingBlock = ResidentBlock::where('resident_id', $request->resident_id)->first();
        if ($existingBlock) {
            return back()->withErrors(['resident_id' => 'Warga ini sudah memiliki blok']);
        }

        // Check if block is already assigned
        $blockExists = ResidentBlock::where('block', $request->block)->first();
        if ($blockExists) {
            return back()->withErrors(['block' => 'Nomor blok ini sudah digunakan oleh warga lain']);
        }

        $residentBlock = ResidentBlock::create($request->all());

        // Auto-create user account
        try {
            User::createFromResidentBlock($residentBlock);
        } catch (\Exception $e) {
            // Log error but don't fail the main operation
            Log::error('Failed to create user for resident block: ' . $e->getMessage());
        }

        return redirect()->route('resident-blocks.index')->with('success', 'Rumah warga berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ResidentBlock $residentBlock)
    {
        $residentBlock->load('resident');
        return view('resident-blocks.show', compact('residentBlock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResidentBlock $residentBlock)
    {
        // Get all residents including the current one
        $availableResidents = FamilyMember::all();

        return view('resident-blocks.edit', compact('residentBlock', 'availableResidents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResidentBlock $residentBlock)
    {
        $request->validate([
            'block' => 'required|string|max:10|unique:resident_blocks,block,' . $residentBlock->id,
            'resident_id' => 'required|exists:family_members,id|unique:resident_blocks,resident_id,' . $residentBlock->id,
        ]);

        // Validate block format
        if (!ResidentBlock::isValidBlockFormat($request->block)) {
            return back()->withErrors(['block' => 'Format blok tidak valid. Gunakan format seperti D1-12 atau D1-12A']);
        }

        // Check if block is already assigned to another resident
        $blockExists = ResidentBlock::where('block', $request->block)
                                    ->where('id', '!=', $residentBlock->id)
                                    ->first();
        if ($blockExists) {
            return back()->withErrors(['block' => 'Nomor blok ini sudah digunakan oleh warga lain']);
        }

        $residentBlock->update($request->all());

        // Update user account if exists
        try {
            $user = User::where('nik', $residentBlock->resident->nik)
                       ->where('block', $residentBlock->block)
                       ->first();

            if ($user) {
                $user->update([
                    'block' => $residentBlock->block,
                    'name' => $residentBlock->resident->name,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to update user for resident block: ' . $e->getMessage());
        }

        return redirect()->route('resident-blocks.index')->with('success', 'Rumah warga berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResidentBlock $residentBlock)
    {
        // Delete associated user account
        try {
            $user = User::where('nik', $residentBlock->resident->nik)
                       ->where('block', $residentBlock->block)
                       ->first();

            if ($user) {
                $user->delete();
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete user for resident block: ' . $e->getMessage());
        }

        $residentBlock->delete();

        return redirect()->route('resident-blocks.index')->with('success', 'Rumah warga berhasil dihapus');
    }
}
