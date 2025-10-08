<?php

namespace App\Http\Controllers;

use App\Models\WaterMeterPhoto;
use App\Models\WaterPeriod;
use App\Models\ResidentBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WaterMeterPhotoController extends Controller
{
    /**
     * Display a listing of water periods for meter photo uploads (User Side)
     */
    public function index()
    {
        $user = Auth::user();

        // Find resident block based on user's block
        $residentBlock = ResidentBlock::where('block', $user->block)->first();

        if (!$residentBlock) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda belum memiliki blok tempat tinggal.');
        }

        // Get active water periods
        $waterPeriods = WaterPeriod::where('status', 'ACTIVE')
            ->orderBy('due_date', 'desc')
            ->get();

        // Get existing meter photos for this block
        $meterPhotos = WaterMeterPhoto::where('block_id', $residentBlock->id)
            ->with(['waterPeriod', 'uploadedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('water-meter-photos.index', compact('waterPeriods', 'meterPhotos', 'residentBlock'));
    }

    /**
     * Store a newly uploaded meter photo
     */
    public function store(Request $request)
    {
        $request->validate([
            'water_period_id' => 'required|exists:water_periods,id',
            'block_id' => 'required|exists:resident_blocks,id',
            'meter_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'water_period_id.required' => 'Periode air harus dipilih.',
            'water_period_id.exists' => 'Periode air tidak valid.',
            'block_id.required' => 'Blok harus dipilih.',
            'block_id.exists' => 'Blok tidak valid.',
            'meter_photo.required' => 'Foto meteran air harus diunggah.',
            'meter_photo.image' => 'File harus berupa gambar.',
            'meter_photo.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'meter_photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $user = Auth::user();

        // Verify that the block belongs to the user
        $residentBlock = ResidentBlock::where('id', $request->block_id)
            ->where('block', $user->block)
            ->first();

        if (!$residentBlock) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke blok ini.');
        }

        // Check if photo already exists for this block and period
        $existingPhoto = WaterMeterPhoto::where('block_id', $request->block_id)
            ->where('water_period_id', $request->water_period_id)
            ->first();

        if ($existingPhoto) {
            return redirect()->back()->with('error', 'Foto meteran untuk periode ini sudah diunggah.');
        }

        // Store the image
        $image = $request->file('meter_photo');
        $imagePath = $image->store('water-meter-photos', 'public');

        // Create the record
        WaterMeterPhoto::create([
            'block_id' => $request->block_id,
            'water_period_id' => $request->water_period_id,
            'image_path' => $imagePath,
            'uploaded_by' => $user->id,
        ]);

        return redirect()->route('water-meter-photos.index')
            ->with('success', 'Foto meteran air berhasil diunggah.');
    }

    /**
     * Display the specified meter photo
     */
    public function show(WaterMeterPhoto $waterMeterPhoto)
    {
        $user = Auth::user();

        // Check if user has permission to view this photo
        if ($user->role === 'user') {
            $residentBlock = ResidentBlock::where('block', $user->block)->first();
            if (!$residentBlock || $waterMeterPhoto->block_id !== $residentBlock->id) {
                abort(403, 'Anda tidak memiliki akses ke foto ini.');
            }
        }

        $waterMeterPhoto->load(['waterPeriod', 'residentBlock', 'uploadedBy']);

        return view('water-meter-photos.show', compact('waterMeterPhoto'));
    }

    /**
     * Remove the specified meter photo
     */
    public function destroy(WaterMeterPhoto $waterMeterPhoto)
    {
        $user = Auth::user();

        // Check if user has permission to delete this photo
        if ($user->role === 'user') {
            $residentBlock = ResidentBlock::where('block', $user->block)->first();
            if (!$residentBlock || $waterMeterPhoto->block_id !== $residentBlock->id) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus foto ini.');
            }
        }

        // Delete the photo file
        $waterMeterPhoto->deletePhotoFile();

        // Delete the record
        $waterMeterPhoto->delete();

        return redirect()->route('water-meter-photos.index')
            ->with('success', 'Foto meteran air berhasil dihapus.');
    }

    /**
     * Update/replace the meter photo
     */
    public function update(Request $request, WaterMeterPhoto $waterMeterPhoto)
    {
        $request->validate([
            'meter_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'meter_photo.required' => 'Foto meteran air harus diunggah.',
            'meter_photo.image' => 'File harus berupa gambar.',
            'meter_photo.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'meter_photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $user = Auth::user();

        // Check if user has permission to update this photo
        if ($user->role === 'user') {
            $residentBlock = ResidentBlock::where('block', $user->block)->first();
            if (!$residentBlock || $waterMeterPhoto->block_id !== $residentBlock->id) {
                abort(403, 'Anda tidak memiliki akses untuk mengubah foto ini.');
            }
        }

        // Delete old photo file
        $waterMeterPhoto->deletePhotoFile();

        // Store the new image
        $image = $request->file('meter_photo');
        $imagePath = $image->store('water-meter-photos', 'public');

        // Update the record
        $waterMeterPhoto->update([
            'image_path' => $imagePath,
            'uploaded_by' => $user->id,
        ]);

        return redirect()->route('water-meter-photos.index')
            ->with('success', 'Foto meteran air berhasil diperbarui.');
    }
}

