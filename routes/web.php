<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FamilyMemberController;

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
    });

    // User routes (can view their own family data)
    Route::middleware(['role:user'])->group(function () {
        Route::get('/my-family', [FamilyController::class, 'myFamily'])->name('my-family');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
