<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public Landing Page & Stats Tracking
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/kos/{kos}/view', [HomeController::class, 'incrementView'])->name('kos.view');
Route::post('/kos/{kos}/click', [HomeController::class, 'incrementClick'])->name('kos.click');

// Auth Routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout Route (Auth)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

use App\Http\Controllers\Admin\KosController;
use App\Http\Controllers\Admin\CampusController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AnalyticsController;

// Role Protected Dashboard & Feature Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/dashboard/owner', [DashboardController::class, 'ownerDashboard'])->name('owner.dashboard');
    Route::get('/dashboard/user', [DashboardController::class, 'userDashboard'])->name('user.dashboard');

    // Admin Management Routes
    Route::get('/admin/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics');
    Route::post('/admin/kos/{ko}/quick-update-rooms', [KosController::class, 'quickUpdateRooms'])->name('admin.kos.quick-update-rooms');
    Route::resource('/admin/kos', KosController::class)->names('admin.kos');
    Route::resource('/admin/campuses', CampusController::class)->names('admin.campuses');
    Route::resource('/admin/facilities', FacilityController::class)->names('admin.facilities');
    Route::resource('/admin/owners', OwnerController::class)->names('admin.owners');
    Route::resource('/admin/users', UserController::class)->names('admin.users');
});
