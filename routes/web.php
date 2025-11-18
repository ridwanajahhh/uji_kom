<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminTokoController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminUserController;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\MemberTokoController;
use App\Http\Controllers\MemberProdukController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Member routes - only for members
    Route::middleware('role:member')->prefix('member')->name('member.')->group(function () {
        Route::resource('toko', MemberTokoController::class);
        Route::resource('produk', MemberProdukController::class);

        // Additional route for deleting product images
        Route::delete('produk/gambar/{gambar}', [MemberProdukController::class, 'deleteGambar'])->name('produk.deleteGambar');
    });

    // Admin routes - only for admins
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('toko', AdminTokoController::class);
        Route::resource('produk', AdminProdukController::class);
        Route::resource('kategori', AdminKategoriController::class);
        Route::resource('user', AdminUserController::class);

        // Additional route for deleting product images
        Route::delete('produk/gambar/{gambar}', [AdminProdukController::class, 'deleteImage'])->name('produk.deleteImage');
    });
});
