<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $families = Family::with('familyMembers')->latest()->paginate(10);
        return view('families.index', compact('families'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('families.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'family_card_number' => 'required|unique:families|max:20',
            'head_of_family_name' => 'required|string|max:255',
            'address' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'village' => 'required|string|max:255',
            'sub_district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:5',
        ]);

        Family::create($request->all());

        return redirect()->route('families.index')->with('success', 'Kartu Keluarga berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $family = Family::with('familyMembers')->findOrFail($id);
        return view('families.show', compact('family'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $family = Family::findOrFail($id);
        return view('families.edit', compact('family'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $family = Family::findOrFail($id);

        $request->validate([
            'family_card_number' => 'required|max:20|unique:families,family_card_number,' . $id,
            'head_of_family_name' => 'required|string|max:255',
            'address' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'village' => 'required|string|max:255',
            'sub_district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:5',
        ]);

        $family->update($request->all());

        return redirect()->route('families.index')->with('success', 'Kartu Keluarga berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $family = Family::findOrFail($id);
        $family->delete();

        return redirect()->route('families.index')->with('success', 'Kartu Keluarga berhasil dihapus');
    }
}
