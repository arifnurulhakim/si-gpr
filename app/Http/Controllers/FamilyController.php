<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = Family::with('familyMembers');

        // Apply sorting
        if (in_array($sortBy, ['family_card_number', 'head_of_family_name', 'rt', 'rw', 'village', 'sub_district', 'city', 'province', 'postal_code', 'block', 'status', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $families = $query->paginate($perPage);
        $families->appends($request->query());

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
            'block' => 'nullable|string|max:10|regex:/^[A-Z][0-9]+-[0-9]+$/',
            'status' => 'required|in:tetap,domisili',
            'family_card_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'family_members' => 'required|array|min:1',
            'family_members.*.nik' => 'required|string|max:16',
            'family_members.*.name' => 'required|string|max:255',
            'family_members.*.gender' => 'required|in:L,P',
            'family_members.*.date_of_birth' => 'required|date',
            'family_members.*.marital_status' => 'required|string|max:255',
            'family_members.*.relationship_to_head' => 'required|string|max:255',
            'family_members.*.citizenship' => 'required|in:WNI,WNA',
            'family_members.*.status' => 'required|in:tetap,domisili',
            'family_members.*.ktp_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['family_card_image', 'family_members']);

        // Handle family card image upload
        if ($request->hasFile('family_card_image')) {
            $image = $request->file('family_card_image');
            $imageName = time() . '_' . $request->family_card_number . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/family-cards', $imageName);
            $data['family_card_image'] = 'family-cards/' . $imageName;
        }

        // Create family
        $family = Family::create($data);

        // Create family members
        $headOfFamily = null;
        foreach ($request->family_members as $index => $memberData) {
            $memberData['family_id'] = $family->id;

            // Handle KTP image upload
            if ($request->hasFile("family_members.{$index}.ktp_image")) {
                $ktpImage = $request->file("family_members.{$index}.ktp_image");
                $ktpImageName = time() . '_' . $memberData['nik'] . '.' . $ktpImage->getClientOriginalExtension();
                $ktpImagePath = $ktpImage->storeAs('public/ktp-images', $ktpImageName);
                $memberData['ktp_image'] = 'ktp-images/' . $ktpImageName;
            }

            $member = $family->familyMembers()->create($memberData);

            // Store head of family data for user creation
            if ($memberData['relationship_to_head'] === 'Kepala Keluarga') {
                $headOfFamily = $member;
            }
        }

        // Auto-create user account for head of family
        if ($headOfFamily) {
            $password = \Carbon\Carbon::parse($headOfFamily->date_of_birth)->format('Y-m-d');

            \App\Models\User::create([
                'name' => $headOfFamily->name,
                'email' => $headOfFamily->nik . '@kk.local', // Temporary email
                'password' => \Hash::make($password),
                'role' => 'user',
                'family_card_number' => $family->family_card_number,
            ]);
        }

        return redirect()->route('families.index')->with('success', 'Kartu Keluarga, anggota keluarga, dan akun user berhasil ditambahkan');
    }

    /**
     * Show user's own family data
     */
    public function myFamily()
    {
        $user = auth()->user();
        $family = $user->family;

        if (!$family) {
            return redirect()->route('dashboard')->with('error', 'Data keluarga tidak ditemukan');
        }

        return view('families.my-family', compact('family'));
    }

    /**
     * Export families to Excel
     */
    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FamiliesExport, 'data-kartu-keluarga-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export single family to PDF
     */
    public function exportPdf(string $id)
    {
        $family = Family::with('familyMembers')->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('families.pdf', compact('family'));

        return $pdf->download('kartu-keluarga-' . $family->family_card_number . '.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $family = Family::findOrFail($id);

        // Get family members with pagination and sorting
        $query = $family->familyMembers();

        // Apply sorting
        if (in_array($sortBy, ['nik', 'name', 'gender', 'date_of_birth', 'marital_status', 'relationship_to_head', 'citizenship', 'status', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $familyMembers = $query->paginate($perPage);
        $familyMembers->appends($request->query());

        return view('families.show', compact('family', 'familyMembers'));
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
            'block' => 'nullable|string|max:10|regex:/^[A-Z][0-9]+-[0-9]+$/',
            'status' => 'required|in:tetap,domisili',
            'family_card_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('family_card_image');

        // Handle file upload
        if ($request->hasFile('family_card_image')) {
            // Delete old image if exists
            if ($family->family_card_image) {
                Storage::delete('public/' . $family->family_card_image);
            }

            $image = $request->file('family_card_image');
            $imageName = time() . '_' . $request->family_card_number . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/family-cards', $imageName);
            $data['family_card_image'] = 'family-cards/' . $imageName;
        }

        $family->update($data);

        return redirect()->route('families.index')->with('success', 'Kartu Keluarga berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $family = Family::findOrFail($id);

        // Delete associated image if exists
        if ($family->family_card_image) {
            Storage::delete('public/' . $family->family_card_image);
        }

        $family->delete();

        return redirect()->route('families.index')->with('success', 'Kartu Keluarga berhasil dihapus');
    }
}
