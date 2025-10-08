<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\ResidentBlockController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\WaterPeriodController;
use App\Http\Controllers\WaterUsageController;
use App\Http\Controllers\WaterMeterPhotoController;
use App\Http\Controllers\CashPeriodController;
use App\Http\Controllers\CashRecordController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Profile Routes
    Route::get('/profile', [UserProfileController::class, 'show'])->name('user-profile.show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('user-profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('user-profile.update');

    // Admin only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('families', FamilyController::class);
        Route::resource('family-members', FamilyMemberController::class);
        Route::resource('resident-blocks', ResidentBlockController::class);
        Route::get('families/export/excel', [FamilyController::class, 'export'])->name('families.export');
        Route::get('families/{id}/export/pdf', [FamilyController::class, 'exportPdf'])->name('families.export.pdf');

        // Water Periods
        Route::resource('water-periods', WaterPeriodController::class);
        Route::post('water-periods/{waterPeriod}/close', [WaterPeriodController::class, 'close'])->name('water-periods.close');
        Route::delete('water-periods/{waterPeriod}/force-delete', [WaterPeriodController::class, 'forceDelete'])->name('water-periods.force-delete');
        Route::get('water-periods/{waterPeriod}/export', [WaterPeriodController::class, 'export'])->name('water-periods.export');

        // Water Usage Records (nested under water periods)
        Route::get('water-periods/{waterPeriod}/records/create', [WaterUsageController::class, 'create'])->name('water-usage.create');
        Route::post('water-periods/{waterPeriod}/records', [WaterUsageController::class, 'store'])->name('water-usage.store');
        Route::get('water-periods/{waterPeriod}/records/{waterUsageRecord}', [WaterUsageController::class, 'show'])->name('water-usage.show');
        Route::get('water-periods/{waterPeriod}/records/{waterUsageRecord}/edit', [WaterUsageController::class, 'edit'])->name('water-usage.edit');
        Route::put('water-periods/{waterPeriod}/records/{waterUsageRecord}', [WaterUsageController::class, 'update'])->name('water-usage.update');
        Route::delete('water-periods/{waterPeriod}/records/{waterUsageRecord}', [WaterUsageController::class, 'destroy'])->name('water-usage.destroy');

        // Payment proof upload and verification
        Route::post('water-periods/{waterPeriod}/records/{waterUsageRecord}/upload-proof', [WaterUsageController::class, 'uploadPaymentProof'])->name('water-usage.upload-proof');
        Route::post('water-periods/{waterPeriod}/records/{waterUsageRecord}/verify', [WaterUsageController::class, 'verifyPayment'])->name('water-usage.verify');

        // Print receipt
        Route::get('water-periods/{waterPeriod}/records/{waterUsageRecord}/print', [WaterUsageController::class, 'printReceipt'])->name('water-usage.print');

        // Cash Periods
        Route::resource('cash-periods', CashPeriodController::class);
        Route::post('cash-periods/{cashPeriod}/close', [CashPeriodController::class, 'close'])->name('cash-periods.close');
        Route::delete('cash-periods/{cashPeriod}/force-delete', [CashPeriodController::class, 'forceDelete'])->name('cash-periods.force-delete');
        Route::get('cash-periods/{cashPeriod}/export', [CashPeriodController::class, 'export'])->name('cash-periods.export');

        // Cash Records (nested under cash periods)
        Route::get('cash-periods/{cashPeriod}/records/create', [CashRecordController::class, 'create'])->name('cash-records.create');
        Route::post('cash-periods/{cashPeriod}/records', [CashRecordController::class, 'store'])->name('cash-records.store');
        Route::get('cash-periods/{cashPeriod}/records/{cashRecord}', [CashRecordController::class, 'show'])->name('cash-records.show');
        Route::get('cash-periods/{cashPeriod}/records/{cashRecord}/edit', [CashRecordController::class, 'edit'])->name('cash-records.edit');
        Route::put('cash-periods/{cashPeriod}/records/{cashRecord}', [CashRecordController::class, 'update'])->name('cash-records.update');
        Route::delete('cash-periods/{cashPeriod}/records/{cashRecord}', [CashRecordController::class, 'destroy'])->name('cash-records.destroy');

        // Payment proof upload and verification
        Route::post('cash-periods/{cashPeriod}/records/{cashRecord}/upload-proof', [CashRecordController::class, 'uploadPaymentProof'])->name('cash-records.upload-proof');
        Route::post('cash-periods/{cashPeriod}/records/{cashRecord}/verify', [CashRecordController::class, 'verifyPayment'])->name('cash-records.verify');

        // Print receipt
        Route::get('cash-periods/{cashPeriod}/records/{cashRecord}/print', [CashRecordController::class, 'printReceipt'])->name('cash-records.print');
    });

    // User routes (can view their own family data)
    Route::middleware(['role:user'])->group(function () {
        Route::get('/my-family', [FamilyController::class, 'myFamily'])->name('my-family');

        // Water usage for users
        Route::get('/my-water-bills', [WaterUsageController::class, 'myWaterBills'])->name('my-water-bills');
        Route::get('/my-water-periods/{waterPeriod}/records/{waterUsageRecord}', [WaterUsageController::class, 'show'])->name('my-water-usage.show');
        Route::post('/my-water-periods/{waterPeriod}/records/{waterUsageRecord}/upload-proof', [WaterUsageController::class, 'uploadPaymentProof'])->name('my-water-usage.upload-proof');
        Route::get('/my-water-periods/{waterPeriod}/records/{waterUsageRecord}/print', [WaterUsageController::class, 'printReceipt'])->name('my-water-usage.print');

        // Water meter photos for users
        Route::get('/water-meter-photos', [WaterMeterPhotoController::class, 'index'])->name('water-meter-photos.index');
        Route::post('/water-meter-photos', [WaterMeterPhotoController::class, 'store'])->name('water-meter-photos.store');
        Route::get('/water-meter-photos/{waterMeterPhoto}', [WaterMeterPhotoController::class, 'show'])->name('water-meter-photos.show');
        Route::put('/water-meter-photos/{waterMeterPhoto}', [WaterMeterPhotoController::class, 'update'])->name('water-meter-photos.update');
        Route::delete('/water-meter-photos/{waterMeterPhoto}', [WaterMeterPhotoController::class, 'destroy'])->name('water-meter-photos.destroy');

        // Cash usage for users
        Route::get('/my-cash-bills', [CashRecordController::class, 'myCashBills'])->name('my-cash-bills');
        Route::get('/my-cash-periods/{cashPeriod}/records/{cashRecord}', [CashRecordController::class, 'show'])->name('my-cash-usage.show');
        Route::post('/my-cash-periods/{cashPeriod}/records/{cashRecord}/upload-proof', [CashRecordController::class, 'uploadPaymentProof'])->name('my-cash-usage.upload-proof');
        Route::get('/my-cash-periods/{cashPeriod}/records/{cashRecord}/print', [CashRecordController::class, 'printReceipt'])->name('my-cash-usage.print');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
