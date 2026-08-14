<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', fn() => view('home'))->name('home');
Route::get('/menu', fn() => view('pages.menu'))->name('menu');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Owner Routes
Route::prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Settings & Staff Management
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    Route::post('/setting/profile', [SettingController::class, 'updateProfile'])->name('setting.profile.update');
    
    Route::post('/users', [SettingController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [SettingController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [SettingController::class, 'destroyUser'])->name('users.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('pages.admin.dashboard'))->name('dashboard');

    // Kelola Menu
    Route::get('/menu', fn() => view('pages.admin.kelola'))->name('menu.index');

    // Kelola Category
    Route::get('/category', [CategoryController::class, 'index'])->name('kelola.category');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
});

// Cashier Routes
Route::prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/orders', fn() => view('pages.cashier.orders'))->name('orders');
});

// Kitchen Routes
Route::prefix('kitchen')->name('kitchen.')->group(function () {
    Route::get('/orders', fn() => view('pages.kitchen.orders'))->name('orders');
});