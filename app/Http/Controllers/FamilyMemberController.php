<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $familyMembers = FamilyMember::with('family')->latest()->paginate(10);
        return view('family-members.index', compact('familyMembers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $families = Family::all();
        $familyId = request('family_id');
        return view('family-members.create', compact('families', 'familyId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'family_id' => 'required|exists:families,id',
            'nik' => 'required|unique:family_members|max:16',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date',
            'marital_status' => 'required|in:BELUM KAWIN,KAWIN,CERAI HIDUP,CERAI MATI',
            'relationship_to_head' => 'required|in:KEPALA KELUARGA,SUAMI,ISTRI,ANAK,ORANGTUA,FAMILI LAIN,PEMBANTU,LAINNYA',
            'citizenship' => 'required|string|max:3',
        ]);

        FamilyMember::create($request->all());

        return redirect()->route('families.show', $request->family_id)->with('success', 'Anggota keluarga berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $familyMember = FamilyMember::with('family')->findOrFail($id);
        return view('family-members.show', compact('familyMember'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $familyMember = FamilyMember::findOrFail($id);
        $families = Family::all();
        return view('family-members.edit', compact('familyMember', 'families'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $familyMember = FamilyMember::findOrFail($id);

        $request->validate([
            'family_id' => 'required|exists:families,id',
            'nik' => 'required|max:16|unique:family_members,nik,' . $id,
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date',
            'marital_status' => 'required|in:BELUM KAWIN,KAWIN,CERAI HIDUP,CERAI MATI',
            'relationship_to_head' => 'required|in:KEPALA KELUARGA,SUAMI,ISTRI,ANAK,ORANGTUA,FAMILI LAIN,PEMBANTU,LAINNYA',
            'citizenship' => 'required|string|max:3',
        ]);

        $familyMember->update($request->all());

        return redirect()->route('families.show', $familyMember->family_id)->with('success', 'Anggota keluarga berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $familyMember = FamilyMember::findOrFail($id);
        $familyId = $familyMember->family_id;
        $familyMember->delete();

        return redirect()->route('families.show', $familyId)->with('success', 'Anggota keluarga berhasil dihapus');
    }
}
