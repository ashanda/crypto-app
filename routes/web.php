<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Auth\PasswordResetController;


Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// Route for showing the password reset request form
Route::get('password/reset', [PasswordResetController::class, 'showResetRequestForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

//Register
// Step 1: User Information
Route::get('/register', [AuthController::class, 'showStep1'])->name('register.step1');
Route::post('/register/step1', [AuthController::class, 'processStep1'])->name('register.processStep1');

// Step 2: Package Selection
Route::get('/register/step2/{id}', [AuthController::class, 'showStep2'])->name('register.step2');
Route::post('/register/step2', [AuthController::class, 'processStep2'])->name('register.processStep2');

// Step 3: Wait for activation
Route::get('/register/step3', [AuthController::class, 'showStep3'])->name('register.step3');

// Protected Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/activate/{user}', [AdminController::class, 'activateUser'])->name('admin.activateUser');
});

Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');
    Route::post('/admin/activate/{user}', [AdminController::class, 'activateUser'])->name('admin.activateUser');
});


Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::post('/admin/activate/{user}', [AdminController::class, 'activateUser'])->name('admin.activateUser');
});


