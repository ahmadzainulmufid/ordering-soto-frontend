<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiningTableController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cashier\CashierOrderController;
use App\Http\Controllers\kitchen\KitchenOrderController;
use App\Http\Controllers\MenuUserController;
use App\Http\Controllers\OrderUserController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\OwnerOrderController;
use App\Http\Controllers\Owner\ReportController;
use App\Http\Controllers\Owner\SettingController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', fn() => view('home'))->name('home');
Route::get('/menu', [MenuUserController::class, 'index'])->name('menu.index');
Route::post('/orders', [OrderUserController::class, 'store'])->name('orders.store');
Route::get('/orders/success/{code}', [OrderUserController::class, 'success'])->name('orders.success');

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

    Route::get('/orders', [OwnerOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{id}/status', [OwnerOrderController::class, 'updateStatus'])->name('orders.update-status');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Kelola Menu
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // Kelola Category
    Route::get('/category', [CategoryController::class, 'index'])->name('kelola.category');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Route Kelola Meja Makan
    Route::get('/table', [DiningTableController::class, 'index'])->name('kelola.table');
    Route::post('/table', [DiningTableController::class, 'store'])->name('table.store');
    Route::put('/table/{id}', [DiningTableController::class, 'update'])->name('table.update');
    Route::delete('/table/{id}', [DiningTableController::class, 'destroy'])->name('table.destroy');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
});

// Cashier Routes
Route::prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/orders', [CashierOrderController::class, 'index'])->name('orders.index');
    Route::get('/menu-stock', [CashierOrderController::class, 'menuStock'])->name('menu.stock');
    Route::post('/orders/manual', [CashierOrderController::class, 'storeManualOrder'])->name('orders.store-manual');
    Route::patch('/orders/{id}/pay', [CashierOrderController::class, 'confirmPayment'])->name('orders.confirm-pay');
    Route::patch('/orders/{id}/status', [CashierOrderController::class, 'updateStatus'])->name('orders.update-status');
});

// Kitchen Routes
Route::prefix('kitchen')->name('kitchen.')->group(function () {
    Route::get('/orders', [KitchenOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{id}/status', [KitchenOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});