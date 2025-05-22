<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HODController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;  // Add this line for AuthController

/*
|---------------------------------------------------------------------- 
| Web Routes 
|---------------------------------------------------------------------- 
| This is where you register web routes for your application. 
| These routes are loaded by the RouteServiceProvider within a group 
| containing the "web" middleware group. Now create something great! 
|
*/

// Home Route
Route::get('/', function () {
    return view('welcome');
});

// Login Route
Route::view('/login', 'pass.login')->name('login');

// HOD Dashboard Route
Route::view('/hod', 'pass.hod')->name('hod.dashboard');

// Office View Route
Route::get('/office', [HODController::class, 'showRequests'])->name('office');

// HOD-Specific Routes (Prefix: /hod)
Route::prefix('hod')->group(function () {
    // View All Requests
    Route::get('/requests', [HODController::class, 'showRequests'])->name('hod.requests');

    // Store a New Gate Pass Request
    Route::post('/store', [HODController::class, 'store'])->name('hod.store');

    // Update the Status of a Request
    Route::patch('/update-status/{id}', [HODController::class, 'updateStatus'])->name('hod.updateStatus');

    // Delete a Gate Pass Request
    Route::delete('/requests/{id}', [HODController::class, 'deleteRequest'])->name('hod.deleteRequest');

    // Approve a Request (additional route if needed, can be integrated with updateStatus)
    Route::post('/approve/{id}', [HODController::class, 'updateStatus'])->name('hod.approve');

    // View Security Page for Approved Requests
    Route::get('/security', [HODController::class, 'showSecurityPage'])->name('hod.security');

    // Confirm a Request in Security
    Route::post('/confirm-request/{id}', [HODController::class, 'confirmRequest'])->name('hod.confirmRequest');

    // Update Info for Gate Pass Request (Security Information)
    Route::post('/update-info/{id}', [HODController::class, 'updateInfo'])->name('hod.updateInfo'); // Ensure this matches your controller method
});

// Security Page (General Access for Security Role)
Route::get('/security', [HODController::class, 'showSecurityPage'])->name('security');

// Password Management Routes
Route::prefix('password')->group(function () {
    // Show Password Change Form
    Route::get('/change', [UserController::class, 'showPasswordForm'])->name('change-password');
    
    // Handle Password Update
    Route::post('/update', [UserController::class, 'updatePassword'])->name('update-password');
});

// User Details Route
Route::get('/user/{userId}/details', [UserController::class, 'getUserDetails'])->name('user.details');

// Testing Route (Optional, for Development)
Route::get('/user-details', [UserController::class, 'getUserDetails'])->name('user.details.test');

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
