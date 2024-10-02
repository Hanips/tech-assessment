<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [ProductController::class, 'index'])->name('index');

Route::middleware('guest')->group(function () {
    Route::post('/register', [CustomerController::class, 'register'])->name('register');
    Route::post('/login', [CustomerController::class, 'login'])->name('login');
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'userlist'])->name('admin.users.index');
    Route::post('/admin/users/{user}/approve', [AdminController::class, 'approveUser'])->name('admin.approve.user');
    
    Route::get('/admin/products', [ProductController::class, 'productList'])->name('admin.products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store'); 
    Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.products.show');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update'); 
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
});

require __DIR__.'/auth.php';
