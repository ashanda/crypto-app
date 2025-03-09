<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GeneologyController;
use App\Http\Controllers\GoogleAuthenticatorController;
use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\TokenController;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;


Route::get('/', function () {
    if (auth()->check()) {
        // Redirect based on user role
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role == 'company') {
            return redirect()->route('company.dashboard');
        } elseif (auth()->user()->role == 'agent') {
            return redirect()->route('agent.dashboard');
        } elseif (auth()->user()->role == 'user') {
            return redirect()->route('user.dashboard');
        }
    }

    // If the user is not authenticated, redirect to login
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
Route::middleware(['auth', 'role:company'])->group(function () {
    Route::get('/company/dashboard', [CompanyController::class, 'index'])->name('company.dashboard');
    Route::post('/company/activate/{user}', [CompanyController::class, 'activateUser'])->name('company.activateUser');
    Route::get('/view-tokens/{userId}', [TokenController::class, 'viewTokens'])->name('view.tokens');
    Route::post('/generate-tokens/{userId}', [TokenController::class, 'generateTokens'])->name('generate.tokens');

    Route::get('/company/pending-activation', [CompanyController::class,'pendingActivation'])->name('company.pending.activation');

    
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/activate/{user}', [AdminController::class, 'activateUser'])->name('admin.activateUser');
    Route::get('/view-tokens/{userId}', [TokenController::class, 'viewTokens'])->name('view.tokens');
    Route::post('/generate-tokens/{userId}', [TokenController::class, 'generateTokens'])->name('generate.tokens');

    Route::get('/admin/pending-activation', [AdminController::class,'pendingActivation'])->name('admin.pending.activation');

    Route::get('/admin/{userId}/setup-google-auth', [GoogleAuthenticatorController::class, 'setupGoogleAuthenticator'])->name('setup.google.auth');

    
});

Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');
    Route::post('/admin/activate/{user}', [AdminController::class, 'activateUser'])->name('admin.activateUser');

    
});


Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::post('/admin/activate/{user}', [AdminController::class, 'activateUser'])->name('admin.activateUser');


    
});

Route::post('/active-package', [TokenController::class, 'activePackage'])->name('active.package');
Route::get('/token-shares', [TokenController::class, 'shareToken'])->name('token.share');
Route::post('/token/share', [TokenController::class, 'shareTokens'])->name('token.shares');

Route::get('/buy-package-history', [PackageController::class, 'buyPackageHistory'])->name('buy.package.history');
Route::get('/buy-package', [PackageController::class,'buyPackage'])->name('buy.package');
Route::post('/buy-packages', [PackageController::class, 'buyPackages'])->name('buy.packages');

Route::get('/my-geneology', [GeneologyController::class,'index'])->name('my.geneology');



