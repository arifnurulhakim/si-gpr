<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\FamilyMember;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'block_code');
        $sortOrder = $request->get('sort_order', 'asc');
        $status = $request->get('status', 'all'); // all, active, inactive

        $query = Block::withCount('familyMembers');

        // Apply status filter
        if ($status === 'active') {
            $query->active();
        } elseif ($status === 'inactive') {
            $query->inactive();
        }

        // Apply sorting
        if (in_array($sortBy, ['block_code', 'description', 'status', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('block_code', 'asc');
        }

        $blocks = $query->paginate($perPage);
        $blocks->appends($request->query());

        // Get counts for filter buttons
        $totalCount = Block::count();
        $activeCount = Block::active()->count();
        $inactiveCount = Block::inactive()->count();

        return view('blocks.index', compact('blocks', 'totalCount', 'activeCount', 'inactiveCount', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blocks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'block_code' => 'required|string|max:10|unique:blocks,block_code',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        // Validate block code format
        if (!Block::isValidBlockCode($request->block_code)) {
            return back()->withErrors(['block_code' => 'Format blok tidak valid. Gunakan format seperti D1-12 atau D1-12A']);
        }

        Block::create($request->all());

        return redirect()->route('blocks.index')->with('success', 'Blok berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Block $block)
    {
        $block->load('familyMembers');
        return view('blocks.show', compact('block'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Block $block)
    {
        return view('blocks.edit', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Block $block)
    {
        $request->validate([
            'block_code' => 'required|string|max:10|unique:blocks,block_code,' . $block->id,
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        // Validate block code format
        if (!Block::isValidBlockCode($request->block_code)) {
            return back()->withErrors(['block_code' => 'Format blok tidak valid. Gunakan format seperti D1-12 atau D1-12A']);
        }

        $block->update($request->all());

        return redirect()->route('blocks.index')->with('success', 'Blok berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Block $block)
    {
        // Check if block has family members
        if ($block->familyMembers()->count() > 0) {
            return redirect()->route('blocks.index')->with('error', 'Tidak dapat menghapus blok yang masih memiliki warga');
        }

        $block->delete();

        return redirect()->route('blocks.index')->with('success', 'Blok berhasil dihapus');
    }

    /**
     * Show form to assign family members to block
     */
    public function showAssignForm(Block $block)
    {
        $availableMembers = FamilyMember::whereDoesntHave('blocks', function($query) use ($block) {
            $query->where('block_id', $block->id);
        })->get();

        $assignedMembers = $block->familyMembers;

        return view('blocks.assign', compact('block', 'availableMembers', 'assignedMembers'));
    }

    /**
     * Assign family members to block
     */
    public function assignMembers(Request $request, Block $block)
    {
        $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:family_members,id',
            'niks' => 'required|array',
            'niks.*' => 'required|string|max:16',
        ]);

        foreach ($request->member_ids as $index => $memberId) {
            $member = FamilyMember::findOrFail($memberId);
            $nik = $request->niks[$index];

            // Check if member is already assigned to this block
            if (!$block->familyMembers()->where('family_member_id', $memberId)->exists()) {
                $block->familyMembers()->attach($memberId, ['nik' => $nik]);
            }
        }

        return redirect()->route('blocks.show', $block)->with('success', 'Warga berhasil ditambahkan ke blok');
    }

    /**
     * Remove family member from block
     */
    public function removeMember(Block $block, FamilyMember $familyMember)
    {
        $block->familyMembers()->detach($familyMember->id);

        return redirect()->route('blocks.show', $block)->with('success', 'Warga berhasil dikeluarkan dari blok');
    }
}