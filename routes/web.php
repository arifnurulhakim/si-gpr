<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\WaterPeriodController;
use App\Http\Controllers\WaterUsageController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('families', FamilyController::class);
        Route::resource('family-members', FamilyMemberController::class);
        Route::get('families/export/excel', [FamilyController::class, 'export'])->name('families.export');
        Route::get('families/{id}/export/pdf', [FamilyController::class, 'exportPdf'])->name('families.export.pdf');

        // Water Periods
        Route::resource('water-periods', WaterPeriodController::class);
        Route::post('water-periods/{waterPeriod}/close', [WaterPeriodController::class, 'close'])->name('water-periods.close');

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
    });

    // User routes (can view their own family data)
    Route::middleware(['role:user'])->group(function () {
        Route::get('/my-family', [FamilyController::class, 'myFamily'])->name('my-family');

        // Water usage for users
        Route::get('/my-water-bills', [WaterUsageController::class, 'myWaterBills'])->name('my-water-bills');
        Route::get('/my-water-periods/{waterPeriod}/records/{waterUsageRecord}', [WaterUsageController::class, 'show'])->name('my-water-usage.show');
        Route::post('/my-water-periods/{waterPeriod}/records/{waterUsageRecord}/upload-proof', [WaterUsageController::class, 'uploadPaymentProof'])->name('my-water-usage.upload-proof');
        Route::get('/my-water-periods/{waterPeriod}/records/{waterUsageRecord}/print', [WaterUsageController::class, 'printReceipt'])->name('my-water-usage.print');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
